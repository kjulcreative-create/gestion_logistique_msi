<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\CategorieArticle;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::with('categorie')
            ->when($request->search, fn($q) => $q->where('designation', 'like', "%{$request->search}%")
                ->orWhere('code', 'like', "%{$request->search}%"))
            ->when($request->categorie_id, fn($q) => $q->where('categorie_id', $request->categorie_id))
            ->when($request->alerte === '1', fn($q) => $q->whereRaw('quantite_stock <= seuil_alerte'))
            ->orderBy('designation')
            ->paginate(20)
            ->withQueryString();

        $categories = CategorieArticle::orderBy('nom')->get();

        return view('articles.index', compact('articles', 'categories'));
    }

    public function create()
    {
        $categories = CategorieArticle::orderBy('nom')->get();
        return view('articles.form', ['article' => new Article(), 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'           => 'required|string|max:20|unique:articles',
            'designation'    => 'required|string|max:200',
            'description'    => 'nullable|string',
            'unite'          => 'required|string|max:30',
            'quantite_stock' => 'required|numeric|min:0',
            'seuil_alerte'   => 'required|numeric|min:0',
            'prix_unitaire'  => 'nullable|numeric|min:0',
            'localisation'   => 'nullable|string|max:200',
            'categorie_id'   => 'nullable|exists:categories_article,id',
            'statut'         => 'required|in:actif,inactif',
        ]);

        Article::create($data);

        return redirect()->route('articles.index')
            ->with('success', 'Article créé avec succès.');
    }

    public function show(Article $article)
    {
        $mouvements = $article->mouvements()->with('user')->orderByDesc('date_mouvement')->take(20)->get();
        return view('articles.show', compact('article', 'mouvements'));
    }

    public function edit(Article $article)
    {
        $categories = CategorieArticle::orderBy('nom')->get();
        return view('articles.form', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'code'           => 'required|string|max:20|unique:articles,code,'.$article->id,
            'designation'    => 'required|string|max:200',
            'description'    => 'nullable|string',
            'unite'          => 'required|string|max:30',
            'quantite_stock' => 'required|numeric|min:0',
            'seuil_alerte'   => 'required|numeric|min:0',
            'prix_unitaire'  => 'nullable|numeric|min:0',
            'localisation'   => 'nullable|string|max:200',
            'categorie_id'   => 'nullable|exists:categories_article,id',
            'statut'         => 'required|in:actif,inactif',
        ]);

        $article->update($data);

        return redirect()->route('articles.index')
            ->with('success', 'Article mis à jour.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article supprimé.');
    }
}
