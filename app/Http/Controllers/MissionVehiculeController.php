<?php

namespace App\Http\Controllers;

use App\Models\MissionVehicule;
use App\Models\Vehicule;
use App\Models\User;
use Illuminate\Http\Request;

class MissionVehiculeController extends Controller
{
    public function index(Request $request)
    {
        $missions = MissionVehicule::with(['vehicule', 'chauffeur', 'demandeur'])
            ->when($request->search, fn($q) => $q->where('reference', 'like', "%{$request->search}%")
                ->orWhere('destination', 'like', "%{$request->search}%"))
            ->when($request->statut, fn($q) => $q->where('statut', $request->statut))
            ->orderByDesc('date_depart')
            ->paginate(15)
            ->withQueryString();

        return view('missions.index', compact('missions'));
    }

    public function create()
    {
        $vehicules  = Vehicule::where('statut', 'disponible')->orderBy('immatriculation')->get();
        $chauffeurs = User::where('actif', true)->orderBy('name')->get();
        return view('missions.form', [
            'mission'    => new MissionVehicule(),
            'vehicules'  => $vehicules,
            'chauffeurs' => $chauffeurs,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'reference'          => 'required|string|unique:missions_vehicule',
            'vehicule_id'        => 'required|exists:vehicules,id',
            'chauffeur_id'       => 'required|exists:users,id',
            'destination'        => 'required|string|max:200',
            'objet'              => 'required|string',
            'date_depart'        => 'required|date',
            'heure_depart'       => 'nullable|date_format:H:i',
            'date_retour_prevue' => 'required|date|after_or_equal:date_depart',
            'statut'             => 'required|in:planifiee,en_cours,terminee,annulee',
            'km_depart'          => 'nullable|integer|min:0',
            'observations'       => 'nullable|string',
        ]);

        $data['demandeur_id'] = auth()->id();

        MissionVehicule::create($data);

        return redirect()->route('missions.index')
            ->with('success', "Mission {$data['reference']} créée avec succès.");
    }

    public function show(MissionVehicule $mission)
    {
        $mission->load('vehicule', 'chauffeur', 'demandeur', 'consommations.user');
        return view('missions.show', compact('mission'));
    }

    public function edit(MissionVehicule $mission)
    {
        $vehicules  = Vehicule::orderBy('immatriculation')->get();
        $chauffeurs = User::where('actif', true)->orderBy('name')->get();
        return view('missions.form', compact('mission', 'vehicules', 'chauffeurs'));
    }

    public function update(Request $request, MissionVehicule $mission)
    {
        $data = $request->validate([
            'reference'          => 'required|string|unique:missions_vehicule,reference,'.$mission->id,
            'vehicule_id'        => 'required|exists:vehicules,id',
            'chauffeur_id'       => 'required|exists:users,id',
            'destination'        => 'required|string|max:200',
            'objet'              => 'required|string',
            'date_depart'        => 'required|date',
            'heure_depart'       => 'nullable|date_format:H:i',
            'date_retour_prevue' => 'required|date',
            'date_retour_reelle' => 'nullable|date',
            'statut'             => 'required|in:planifiee,en_cours,terminee,annulee',
            'km_depart'          => 'nullable|integer|min:0',
            'km_retour'          => 'nullable|integer|min:0',
            'observations'       => 'nullable|string',
        ]);

        $mission->update($data);

        return redirect()->route('missions.show', $mission)
            ->with('success', 'Mission mise à jour.');
    }

    public function updateStatut(Request $request, MissionVehicule $mission)
    {
        $request->validate(['statut' => 'required|in:planifiee,en_cours,terminee,annulee']);
        $mission->update(['statut' => $request->statut]);
        return back()->with('success', 'Statut mis à jour.');
    }

    public function destroy(MissionVehicule $mission)
    {
        $mission->delete();
        return redirect()->route('missions.index')->with('success', 'Mission supprimée.');
    }
}
