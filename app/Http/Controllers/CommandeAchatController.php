<?php

namespace App\Http\Controllers;

use App\Models\CommandeAchat;
use App\Models\Fournisseur;
use App\Models\Article;
use App\Models\LigneCommande;
use Illuminate\Http\Request;

class CommandeAchatController extends Controller
{
    public function index(Request $request)
    {
        $commandes = CommandeAchat::with('fournisseur', 'user')
            ->when($request->search, fn($q) => $q->where('reference', 'like', "%{$request->search}%"))
            ->when($request->statut, fn($q) => $q->where('statut', $request->statut))
            ->orderByDesc('date_commande')
            ->paginate(15)
            ->withQueryString();

        return view('commandes.index', compact('commandes'));
    }

    public function create()
    {
        $fournisseurs = Fournisseur::where('statut', 'actif')->orderBy('nom')->get();
        $articles     = Article::where('statut', 'actif')->orderBy('designation')->get();
        return view('commandes.form', ['commande' => new CommandeAchat(), 'fournisseurs' => $fournisseurs, 'articles' => $articles]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'reference'             => 'required|string|unique:commandes_achats',
            'fournisseur_id'        => 'required|exists:fournisseurs,id',
            'date_commande'         => 'required|date',
            'date_livraison_prevue' => 'nullable|date|after_or_equal:date_commande',
            'statut'                => 'required|in:brouillon,validee,en_cours,livree,annulee',
            'notes'                 => 'nullable|string',
            'lignes'                => 'required|array|min:1',
            'lignes.*.article_id'   => 'required|exists:articles,id',
            'lignes.*.quantite'     => 'required|numeric|min:0.01',
            'lignes.*.prix_unitaire'=> 'required|numeric|min:0',
        ]);

        $montant = collect($data['lignes'])->sum(fn($l) => $l['quantite'] * $l['prix_unitaire']);

        $commande = CommandeAchat::create([
            ...$data,
            'user_id'       => auth()->id(),
            'montant_total' => $montant,
        ]);

        foreach ($data['lignes'] as $ligne) {
            LigneCommande::create([
                'commande_id'    => $commande->id,
                'article_id'     => $ligne['article_id'],
                'quantite'       => $ligne['quantite'],
                'prix_unitaire'  => $ligne['prix_unitaire'],
                'montant_ligne'  => $ligne['quantite'] * $ligne['prix_unitaire'],
            ]);
        }

        return redirect()->route('commandes.show', $commande)
            ->with('success', "Bon de commande {$commande->reference} créé avec succès.");
    }

    public function show(CommandeAchat $commande)
    {
        $commande->load('fournisseur', 'user', 'lignes.article');
        return view('commandes.show', compact('commande'));
    }

    public function edit(CommandeAchat $commande)
    {
        $fournisseurs = Fournisseur::where('statut', 'actif')->orderBy('nom')->get();
        $articles     = Article::where('statut', 'actif')->orderBy('designation')->get();
        $commande->load('lignes.article');
        return view('commandes.form', compact('commande', 'fournisseurs', 'articles'));
    }

    public function update(Request $request, CommandeAchat $commande)
    {
        $data = $request->validate([
            'reference'             => 'required|string|unique:commandes_achats,reference,'.$commande->id,
            'fournisseur_id'        => 'required|exists:fournisseurs,id',
            'date_commande'         => 'required|date',
            'date_livraison_prevue' => 'nullable|date',
            'date_livraison_reelle' => 'nullable|date',
            'statut'                => 'required|in:brouillon,validee,en_cours,livree,annulee',
            'notes'                 => 'nullable|string',
        ]);

        $commande->update($data);

        return redirect()->route('commandes.show', $commande)
            ->with('success', 'Commande mise à jour.');
    }

    public function updateStatut(Request $request, CommandeAchat $commande)
    {
        $request->validate(['statut' => 'required|in:brouillon,validee,en_cours,livree,annulee']);
        $commande->update(['statut' => $request->statut]);
        return back()->with('success', 'Statut mis à jour.');
    }

    public function destroy(CommandeAchat $commande)
    {
        $commande->delete();
        return redirect()->route('commandes.index')->with('success', 'Commande supprimée.');
    }
}
