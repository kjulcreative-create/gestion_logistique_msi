@extends('layouts.admin')
@section('title', $mission->reference)
@section('page-title', 'Mission '.$mission->reference)

@section('content')
<div class="section-header">
    <div>
        <h2 class="page-title">Mission {{ $mission->reference }}</h2>
        <p class="page-subtitle">{{ $mission->destination }} · {{ $mission->date_depart->format('d/m/Y') }}</p>
    </div>
    <div class="flex gap-2">
        <span class="badge {{ $mission->statut_class }} text-sm px-3 py-1.5">{{ $mission->statut_libelle }}</span>
        <a href="{{ route('missions.edit', $mission) }}" class="btn-primary">Modifier</a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="space-y-4">
        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Détails de la mission</h3>
            <dl class="space-y-2 text-sm">
                <div><dt class="text-gray-500 text-xs mb-0.5">Objet</dt><dd class="font-medium">{{ $mission->objet }}</dd></div>
                <div class="flex justify-between pt-2"><dt class="text-gray-500">Véhicule</dt><dd class="font-mono font-bold">{{ $mission->vehicule->immatriculation }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Chauffeur</dt><dd class="font-medium">{{ $mission->chauffeur->name }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Demandeur</dt><dd class="font-medium">{{ $mission->demandeur->name }}</dd></div>
                <div class="flex justify-between pt-2 border-t"><dt class="text-gray-500">Départ</dt><dd>{{ $mission->date_depart->format('d/m/Y') }} @if($mission->heure_depart) à {{ $mission->heure_depart }} @endif</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Retour prévu</dt><dd>{{ $mission->date_retour_prevue->format('d/m/Y') }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Retour réel</dt><dd>{{ $mission->date_retour_reelle?->format('d/m/Y') ?? '—' }}</dd></div>
                <div class="flex justify-between pt-2 border-t"><dt class="text-gray-500">Km départ</dt><dd>{{ $mission->km_depart ? number_format($mission->km_depart,0,',',' ') : '—' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Km retour</dt><dd>{{ $mission->km_retour ? number_format($mission->km_retour,0,',',' ') : '—' }}</dd></div>
                @if($mission->getKmParcourus())
                <div class="flex justify-between font-bold text-emerald-700"><dt>Km parcourus</dt><dd>{{ number_format($mission->getKmParcourus(),0,',',' ') }} km</dd></div>
                @endif
            </dl>
        </div>

        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 mb-3">Changer le statut</h3>
            <form method="POST" action="{{ route('missions.statut', $mission) }}">
                @csrf @method('PATCH')
                <select name="statut" class="form-select mb-3">
                    @foreach(['planifiee'=>'Planifiée','en_cours'=>'En cours','terminee'=>'Terminée','annulee'=>'Annulée'] as $val=>$lib)
                    <option value="{{ $val }}" @selected($mission->statut===$val)>{{ $lib }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-primary w-full justify-center">Appliquer</button>
            </form>
        </div>
    </div>

    <div class="lg:col-span-2 card p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900">Consommations carburant de la mission</h3>
            <a href="{{ route('carburant.create', ['vehicule_id'=>$mission->vehicule_id,'mission_id'=>$mission->id]) }}" class="btn-secondary text-xs">+ Ajouter</a>
        </div>
        @if($mission->consommations->count())
        <table class="w-full text-sm mb-3">
            <thead class="text-xs text-gray-500 border-b"><tr>
                <th class="pb-2 text-left font-medium">Date</th>
                <th class="pb-2 text-right font-medium">Litres</th>
                <th class="pb-2 text-right font-medium">Prix/L</th>
                <th class="pb-2 text-right font-medium">Montant</th>
                <th class="pb-2 text-left pl-4 font-medium">Station</th>
            </tr></thead>
            <tbody>
                @foreach($mission->consommations as $c)
                <tr class="table-row">
                    <td class="py-2 text-gray-500">{{ $c->date->format('d/m/Y') }}</td>
                    <td class="py-2 text-right font-medium">{{ $c->quantite_litres }} L</td>
                    <td class="py-2 text-right text-gray-500">{{ number_format($c->prix_litre,0) }}</td>
                    <td class="py-2 text-right font-bold">{{ number_format($c->montant_total,0,',',' ') }} FCFA</td>
                    <td class="py-2 pl-4 text-gray-500">{{ $c->station ?? '—' }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="border-t-2 border-gray-200">
                <tr>
                    <td colspan="3" class="pt-3 text-right font-semibold text-gray-700">Total carburant :</td>
                    <td class="pt-3 text-right font-bold text-gray-900">{{ number_format($mission->consommations->sum('montant_total'),0,',',' ') }} FCFA</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        @else
        <p class="text-sm text-gray-400 py-4">Aucune consommation carburant enregistrée pour cette mission.</p>
        @endif

        @if($mission->observations)
        <div class="mt-4 pt-4 border-t">
            <p class="text-xs text-gray-500 font-medium mb-1">Observations</p>
            <p class="text-sm text-gray-700">{{ $mission->observations }}</p>
        </div>
        @endif
    </div>
</div>
@endsection
