<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    public function index(Request $request)
    {
        $fournisseurs = Fournisseur::query()
            ->when($request->search, fn($q) => $q->where('nom', 'like', "%{$request->search}%")
                ->orWhere('code', 'like', "%{$request->search}%"))
            ->when($request->statut, fn($q) => $q->where('statut', $request->statut))
            ->orderBy('nom')
            ->paginate(15)
            ->withQueryString();

        return view('fournisseurs.index', compact('fournisseurs'));
    }

    public function create()
    {
        return view('fournisseurs.form', ['fournisseur' => new Fournisseur()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'           => 'required|string|max:20|unique:fournisseurs',
            'nom'            => 'required|string|max:200',
            'contact'        => 'nullable|string|max:100',
            'telephone'      => 'nullable|string|max:50',
            'email'          => 'nullable|email|max:100',
            'adresse'        => 'nullable|string',
            'ville'          => 'nullable|string|max:100',
            'pays'           => 'nullable|string|max:100',
            'type_fourniture'=> 'nullable|string|max:200',
            'statut'         => 'required|in:actif,inactif',
        ]);

        Fournisseur::create($data);

        return redirect()->route('fournisseurs.index')
            ->with('success', 'Fournisseur créé avec succès.');
    }

    public function show(Fournisseur $fournisseur)
    {
        $commandes = $fournisseur->commandes()->orderByDesc('date_commande')->take(10)->get();
        return view('fournisseurs.show', compact('fournisseur', 'commandes'));
    }

    public function edit(Fournisseur $fournisseur)
    {
        return view('fournisseurs.form', compact('fournisseur'));
    }

    public function update(Request $request, Fournisseur $fournisseur)
    {
        $data = $request->validate([
            'code'           => 'required|string|max:20|unique:fournisseurs,code,'.$fournisseur->id,
            'nom'            => 'required|string|max:200',
            'contact'        => 'nullable|string|max:100',
            'telephone'      => 'nullable|string|max:50',
            'email'          => 'nullable|email|max:100',
            'adresse'        => 'nullable|string',
            'ville'          => 'nullable|string|max:100',
            'pays'           => 'nullable|string|max:100',
            'type_fourniture'=> 'nullable|string|max:200',
            'statut'         => 'required|in:actif,inactif',
        ]);

        $fournisseur->update($data);

        return redirect()->route('fournisseurs.index')
            ->with('success', 'Fournisseur mis à jour avec succès.');
    }

    public function destroy(Fournisseur $fournisseur)
    {
        $fournisseur->delete();
        return redirect()->route('fournisseurs.index')
            ->with('success', 'Fournisseur supprimé.');
    }
}
