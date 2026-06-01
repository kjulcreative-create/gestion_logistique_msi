<?php

namespace App\Http\Controllers;

use App\Models\Equipement;
use App\Models\MaintenanceEquipement;
use App\Models\User;
use Illuminate\Http\Request;

class EquipementController extends Controller
{
    public function index(Request $request)
    {
        $equipements = Equipement::with('responsable')
            ->when($request->search, fn($q) => $q->where('designation', 'like', "%{$request->search}%")
                ->orWhere('code', 'like', "%{$request->search}%"))
            ->when($request->statut, fn($q) => $q->where('statut', $request->statut))
            ->orderBy('code')
            ->paginate(15)
            ->withQueryString();

        return view('equipements.index', compact('equipements'));
    }

    public function create()
    {
        $responsables = User::where('actif', true)->orderBy('name')->get();
        return view('equipements.form', ['equipement' => new Equipement(), 'responsables' => $responsables]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'                   => 'required|string|max:30|unique:equipements',
            'designation'            => 'required|string|max:200',
            'marque'                 => 'nullable|string|max:100',
            'modele'                 => 'nullable|string|max:100',
            'numero_serie'           => 'nullable|string|max:100',
            'date_acquisition'       => 'nullable|date',
            'valeur_acquisition'     => 'nullable|numeric|min:0',
            'fournisseur_acquisition'=> 'nullable|string|max:200',
            'statut'                 => 'required|in:en_service,en_maintenance,hors_service,reforme',
            'localisation'           => 'nullable|string|max:200',
            'affectation'            => 'nullable|string|max:200',
            'responsable_id'         => 'nullable|exists:users,id',
            'date_prochain_entretien'=> 'nullable|date',
            'notes'                  => 'nullable|string',
        ]);

        Equipement::create($data);

        return redirect()->route('equipements.index')
            ->with('success', 'Équipement enregistré avec succès.');
    }

    public function show(Equipement $equipement)
    {
        $maintenances = $equipement->maintenances()->with('user')->orderByDesc('date_maintenance')->get();
        return view('equipements.show', compact('equipement', 'maintenances'));
    }

    public function edit(Equipement $equipement)
    {
        $responsables = User::where('actif', true)->orderBy('name')->get();
        return view('equipements.form', compact('equipement', 'responsables'));
    }

    public function update(Request $request, Equipement $equipement)
    {
        $data = $request->validate([
            'code'                   => 'required|string|max:30|unique:equipements,code,'.$equipement->id,
            'designation'            => 'required|string|max:200',
            'marque'                 => 'nullable|string|max:100',
            'modele'                 => 'nullable|string|max:100',
            'numero_serie'           => 'nullable|string|max:100',
            'date_acquisition'       => 'nullable|date',
            'valeur_acquisition'     => 'nullable|numeric|min:0',
            'fournisseur_acquisition'=> 'nullable|string|max:200',
            'statut'                 => 'required|in:en_service,en_maintenance,hors_service,reforme',
            'localisation'           => 'nullable|string|max:200',
            'affectation'            => 'nullable|string|max:200',
            'responsable_id'         => 'nullable|exists:users,id',
            'date_prochain_entretien'=> 'nullable|date',
            'notes'                  => 'nullable|string',
        ]);

        $equipement->update($data);

        return redirect()->route('equipements.show', $equipement)
            ->with('success', 'Équipement mis à jour.');
    }

    public function destroy(Equipement $equipement)
    {
        $equipement->delete();
        return redirect()->route('equipements.index')->with('success', 'Équipement supprimé.');
    }
}
