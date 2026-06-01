<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use App\Models\MaintenanceVehicule;
use App\Models\User;
use Illuminate\Http\Request;

class VehiculeController extends Controller
{
    public function index(Request $request)
    {
        $vehicules = Vehicule::with('chauffeur')
            ->when($request->search, fn($q) => $q->where('immatriculation', 'like', "%{$request->search}%")
                ->orWhere('marque', 'like', "%{$request->search}%")
                ->orWhere('modele', 'like', "%{$request->search}%"))
            ->when($request->statut, fn($q) => $q->where('statut', $request->statut))
            ->orderBy('immatriculation')
            ->paginate(15)
            ->withQueryString();

        return view('vehicules.index', compact('vehicules'));
    }

    public function create()
    {
        $chauffeurs = User::where('actif', true)->orderBy('name')->get();
        return view('vehicules.form', ['vehicule' => new Vehicule(), 'chauffeurs' => $chauffeurs]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'immatriculation'                  => 'required|string|max:20|unique:vehicules',
            'marque'                           => 'required|string|max:60',
            'modele'                           => 'required|string|max:100',
            'annee'                            => 'required|integer|min:2000|max:2030',
            'type_carburant'                   => 'required|in:essence,diesel,hybride,electrique',
            'couleur'                          => 'nullable|string|max:50',
            'numero_chassis'                   => 'nullable|string|max:100',
            'kilometrage_actuel'               => 'required|integer|min:0',
            'statut'                           => 'required|in:disponible,en_mission,en_maintenance,hors_service',
            'affectation'                      => 'nullable|string|max:200',
            'chauffeur_id'                     => 'nullable|exists:users,id',
            'date_acquisition'                 => 'nullable|date',
            'valeur_acquisition'               => 'nullable|numeric|min:0',
            'date_expiration_assurance'        => 'nullable|date',
            'date_expiration_visite_technique' => 'nullable|date',
            'prochain_entretien_date'          => 'nullable|date',
            'prochain_entretien_km'            => 'nullable|integer|min:0',
            'notes'                            => 'nullable|string',
        ]);

        Vehicule::create($data);

        return redirect()->route('vehicules.index')
            ->with('success', 'Véhicule enregistré avec succès.');
    }

    public function show(Vehicule $vehicule)
    {
        $vehicule->load('chauffeur');
        $missions     = $vehicule->missions()->with('chauffeur')->orderByDesc('date_depart')->take(10)->get();
        $maintenances = $vehicule->maintenances()->orderByDesc('date_maintenance')->take(10)->get();
        $consommations= $vehicule->consommations()->orderByDesc('date')->take(10)->get();
        return view('vehicules.show', compact('vehicule', 'missions', 'maintenances', 'consommations'));
    }

    public function edit(Vehicule $vehicule)
    {
        $chauffeurs = User::where('actif', true)->orderBy('name')->get();
        return view('vehicules.form', compact('vehicule', 'chauffeurs'));
    }

    public function update(Request $request, Vehicule $vehicule)
    {
        $data = $request->validate([
            'immatriculation'                  => 'required|string|max:20|unique:vehicules,immatriculation,'.$vehicule->id,
            'marque'                           => 'required|string|max:60',
            'modele'                           => 'required|string|max:100',
            'annee'                            => 'required|integer|min:2000|max:2030',
            'type_carburant'                   => 'required|in:essence,diesel,hybride,electrique',
            'couleur'                          => 'nullable|string|max:50',
            'numero_chassis'                   => 'nullable|string|max:100',
            'kilometrage_actuel'               => 'required|integer|min:0',
            'statut'                           => 'required|in:disponible,en_mission,en_maintenance,hors_service',
            'affectation'                      => 'nullable|string|max:200',
            'chauffeur_id'                     => 'nullable|exists:users,id',
            'date_acquisition'                 => 'nullable|date',
            'valeur_acquisition'               => 'nullable|numeric|min:0',
            'date_expiration_assurance'        => 'nullable|date',
            'date_expiration_visite_technique' => 'nullable|date',
            'prochain_entretien_date'          => 'nullable|date',
            'prochain_entretien_km'            => 'nullable|integer|min:0',
            'notes'                            => 'nullable|string',
        ]);

        $vehicule->update($data);

        return redirect()->route('vehicules.show', $vehicule)
            ->with('success', 'Véhicule mis à jour.');
    }

    public function destroy(Vehicule $vehicule)
    {
        $vehicule->delete();
        return redirect()->route('vehicules.index')->with('success', 'Véhicule supprimé.');
    }
}
