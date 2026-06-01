<?php

namespace App\Http\Controllers;

use App\Models\ConsommationCarburant;
use App\Models\Vehicule;
use App\Models\MissionVehicule;
use Illuminate\Http\Request;

class CarburantController extends Controller
{
    public function index(Request $request)
    {
        $consommations = ConsommationCarburant::with(['vehicule', 'user', 'mission'])
            ->when($request->vehicule_id, fn($q) => $q->where('vehicule_id', $request->vehicule_id))
            ->orderByDesc('date')
            ->paginate(20)
            ->withQueryString();

        $vehicules = Vehicule::orderBy('immatriculation')->get();
        $totalMois = ConsommationCarburant::whereRaw("strftime('%Y-%m', date) = strftime('%Y-%m', 'now')")
            ->sum('montant_total');

        return view('carburant.index', compact('consommations', 'vehicules', 'totalMois'));
    }

    public function create()
    {
        $vehicules = Vehicule::orderBy('immatriculation')->get();
        $missions  = MissionVehicule::whereIn('statut', ['planifiee', 'en_cours'])
            ->with('vehicule')
            ->orderByDesc('date_depart')
            ->get();
        return view('carburant.create', compact('vehicules', 'missions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicule_id'    => 'required|exists:vehicules,id',
            'mission_id'     => 'nullable|exists:missions_vehicule,id',
            'date'           => 'required|date',
            'quantite_litres'=> 'required|numeric|min:0.1',
            'prix_litre'     => 'required|numeric|min:0',
            'station'        => 'nullable|string|max:100',
            'km_compteur'    => 'nullable|integer|min:0',
            'notes'          => 'nullable|string',
        ]);

        $data['user_id']     = auth()->id();
        $data['montant_total'] = $data['quantite_litres'] * $data['prix_litre'];

        ConsommationCarburant::create($data);

        if ($data['km_compteur']) {
            Vehicule::find($data['vehicule_id'])->update(['kilometrage_actuel' => $data['km_compteur']]);
        }

        return redirect()->route('carburant.index')
            ->with('success', 'Consommation carburant enregistrée.');
    }

    public function show(ConsommationCarburant $carburant)
    {
        $carburant->load('vehicule', 'user', 'mission');
        return view('carburant.show', compact('carburant'));
    }

    public function destroy(ConsommationCarburant $carburant)
    {
        $carburant->delete();
        return redirect()->route('carburant.index')->with('success', 'Enregistrement supprimé.');
    }
}
