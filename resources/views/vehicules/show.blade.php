@extends('layouts.admin')
@section('title', $vehicule->immatriculation)
@section('page-title', $vehicule->immatriculation)

@section('content')
<div class="section-header">
    <div>
        <h2 class="page-title">{{ $vehicule->marque }} {{ $vehicule->modele }} ({{ $vehicule->annee }})</h2>
        <p class="page-subtitle font-mono">{{ $vehicule->immatriculation }} · {{ number_format($vehicule->kilometrage_actuel,0,',',' ') }} km</p>
    </div>
    <div class="flex gap-2">
        <span class="badge {{ $vehicule->statut_class }} text-sm px-3 py-1.5">{{ $vehicule->statut_libelle }}</span>
        <a href="{{ route('missions.create', ['vehicule_id'=>$vehicule->id]) }}" class="btn-secondary">Nouvelle mission</a>
        <a href="{{ route('carburant.create', ['vehicule_id'=>$vehicule->id]) }}" class="btn-secondary">Carburant</a>
        <a href="{{ route('vehicules.edit', $vehicule) }}" class="btn-primary">Modifier</a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="space-y-4">
        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Informations véhicule</h3>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-gray-500">Carburant</dt><dd class="font-medium capitalize">{{ $vehicule->type_carburant }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Couleur</dt><dd class="font-medium">{{ $vehicule->couleur ?? '—' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Châssis</dt><dd class="font-mono text-xs">{{ $vehicule->numero_chassis ?? '—' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Chauffeur</dt><dd class="font-medium">{{ $vehicule->chauffeur?->name ?? '—' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Affectation</dt><dd class="font-medium text-right max-w-xs text-xs">{{ $vehicule->affectation ?? '—' }}</dd></div>
            </dl>
        </div>
        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Documents & Entretien</h3>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500">Assurance</dt>
                    <dd class="font-medium {{ $vehicule->assuranceExpiree() ? 'text-red-600' : '' }}">{{ $vehicule->date_expiration_assurance?->format('d/m/Y') ?? '—' }}</dd>
                </div>
                <div class="flex justify-between"><dt class="text-gray-500">Visite technique</dt><dd class="font-medium">{{ $vehicule->date_expiration_visite_technique?->format('d/m/Y') ?? '—' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Prochain entretien</dt><dd class="font-medium">{{ $vehicule->prochain_entretien_date?->format('d/m/Y') ?? '—' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Prochain entretien km</dt><dd class="font-medium">{{ $vehicule->prochain_entretien_km ? number_format($vehicule->prochain_entretien_km,0,',',' ').' km' : '—' }}</dd></div>
            </dl>
        </div>
    </div>

    <div class="lg:col-span-2 space-y-4">
        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Missions récentes</h3>
            @forelse($missions as $msn)
            <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0 text-sm">
                <div>
                    <a href="{{ route('missions.show', $msn) }}" class="font-medium text-gray-900 hover:text-emerald-600">{{ $msn->destination }}</a>
                    <p class="text-xs text-gray-500">{{ $msn->date_depart->format('d/m/Y') }} → {{ $msn->date_retour_prevue->format('d/m/Y') }} · {{ $msn->chauffeur->name }}</p>
                </div>
                <span class="badge {{ $msn->statut_class }} flex-shrink-0">{{ $msn->statut_libelle }}</span>
            </div>
            @empty
            <p class="text-sm text-gray-400 py-2">Aucune mission enregistrée</p>
            @endforelse
        </div>

        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Consommations carburant récentes</h3>
            <table class="w-full text-sm">
                <thead class="text-xs text-gray-500 border-b"><tr>
                    <th class="pb-2 text-left font-medium">Date</th>
                    <th class="pb-2 text-right font-medium">Litres</th>
                    <th class="pb-2 text-right font-medium">Montant</th>
                    <th class="pb-2 text-left font-medium pl-4">Station</th>
                </tr></thead>
                <tbody>
                    @forelse($consommations as $c)
                    <tr class="table-row">
                        <td class="py-2 text-gray-500">{{ $c->date->format('d/m/Y') }}</td>
                        <td class="py-2 text-right font-medium">{{ $c->quantite_litres }} L</td>
                        <td class="py-2 text-right font-medium">{{ number_format($c->montant_total,0,',',' ') }} FCFA</td>
                        <td class="py-2 pl-4 text-gray-500">{{ $c->station ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="py-3 text-center text-gray-400">Aucune consommation</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
