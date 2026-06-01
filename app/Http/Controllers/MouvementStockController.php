<?php

namespace App\Http\Controllers;

use App\Models\MouvementStock;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MouvementStockController extends Controller
{
    public function index(Request $request)
    {
        $mouvements = MouvementStock::with(['article', 'user'])
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->when($request->article_id, fn($q) => $q->where('article_id', $request->article_id))
            ->orderByDesc('date_mouvement')
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        $articles = Article::orderBy('designation')->get();

        return view('mouvements.index', compact('mouvements', 'articles'));
    }

    public function create()
    {
        $articles = Article::where('statut', 'actif')->orderBy('designation')->get();
        return view('mouvements.create', compact('articles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'article_id'     => 'required|exists:articles,id',
            'type'           => 'required|in:entree,sortie,ajustement',
            'quantite'       => 'required|numeric|min:0.01',
            'motif'          => 'required|string|max:200',
            'reference_doc'  => 'nullable|string|max:100',
            'date_mouvement' => 'required|date',
            'notes'          => 'nullable|string',
        ]);

        DB::transaction(function () use ($data) {
            $article = Article::lockForUpdate()->find($data['article_id']);
            $avant   = $article->quantite_stock;

            $apres = match($data['type']) {
                'entree'     => $avant + $data['quantite'],
                'sortie'     => $avant - $data['quantite'],
                'ajustement' => $data['quantite'],
            };

            MouvementStock::create([
                ...$data,
                'user_id'        => auth()->id(),
                'quantite_avant' => $avant,
                'quantite_apres' => $apres,
            ]);

            $article->update(['quantite_stock' => $apres]);
        });

        return redirect()->route('mouvements.index')
            ->with('success', 'Mouvement de stock enregistré avec succès.');
    }

    public function show(MouvementStock $mouvement)
    {
        $mouvement->load('article', 'user');
        return view('mouvements.show', compact('mouvement'));
    }
}
