@extends('layouts.admin')
@section('title', $equipement->designation)
@section('page-title', $equipement->designation)

@section('content')
<div class="section-header">
    <div>
        <h2 class="page-title">{{ $equipement->designation }}</h2>
        <p class="page-subtitle">{{ $equipement->code }} · {{ $equipement->marque }} {{ $equipement->modele }}</p>
    </div>
    <div class="flex gap-2">
        <span class="badge {{ $equipement->statut_class }} text-sm px-3 py-1.5">{{ $equipement->statut_libelle }}</span>
        <a href="{{ route('equipements.edit', $equipement) }}" class="btn-primary">Modifier</a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="card p-5">
        <h3 class="font-semibold text-gray-900 mb-4">Informations</h3>
        <dl class="space-y-2 text-sm">
            <div class="flex justify-between"><dt class="text-gray-500">N° de série</dt><dd class="font-medium font-mono text-xs">{{ $equipement->numero_serie ?? '—' }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Date acquisition</dt><dd class="font-medium">{{ $equipement->date_acquisition?->format('d/m/Y') ?? '—' }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Valeur</dt><dd class="font-medium">{{ $equipement->valeur_acquisition ? number_format($equipement->valeur_acquisition,0,',',' ').' FCFA' : '—' }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Localisation</dt><dd class="font-medium text-right">{{ $equipement->localisation ?? '—' }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Affectation</dt><dd class="font-medium text-right">{{ $equipement->affectation ?? '—' }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Responsable</dt><dd class="font-medium">{{ $equipement->responsable?->name ?? '—' }}</dd></div>
            <div class="flex justify-between pt-2 border-t"><dt class="text-gray-500">Prochain entretien</dt><dd class="font-medium {{ $equipement->date_prochain_entretien?->isPast() ? 'text-red-600' : '' }}">{{ $equipement->date_prochain_entretien?->format('d/m/Y') ?? '—' }}</dd></div>
        </dl>
        @if($equipement->notes)
        <div class="mt-3 pt-3 border-t text-sm text-gray-600">{{ $equipement->notes }}</div>
        @endif
    </div>

    <div class="lg:col-span-2 card p-5">
        <h3 class="font-semibold text-gray-900 mb-4">Historique des maintenances</h3>
        @forelse($maintenances as $maint)
        <div class="border border-gray-100 rounded-lg p-4 mb-3 last:mb-0">
            <div class="flex items-start justify-between mb-2">
                <div>
                    <span class="badge {{ $maint->type_maintenance === 'preventive' ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700' }} mb-1">
                        {{ ucfirst($maint->type_maintenance) }}
                    </span>
                    <p class="text-sm font-medium text-gray-900">{{ $maint->description }}</p>
                </div>
                <div class="text-right flex-shrink-0 ml-4">
                    <p class="text-sm font-bold text-gray-900">{{ $maint->cout ? number_format($maint->cout,0,',',' ').' FCFA' : '—' }}</p>
                    <p class="text-xs text-gray-500">{{ $maint->date_maintenance->format('d/m/Y') }}</p>
                </div>
            </div>
            <div class="flex gap-4 text-xs text-gray-500">
                @if($maint->prestataire)<span>Prestataire: {{ $maint->prestataire }}</span>@endif
                @if($maint->prochain_entretien)<span>Prochain: {{ $maint->prochain_entretien->format('d/m/Y') }}</span>@endif
                <span>Par: {{ $maint->user->name }}</span>
            </div>
        </div>
        @empty
        <p class="text-sm text-gray-400 py-4 text-center">Aucune maintenance enregistrée</p>
        @endforelse
    </div>
</div>
@endsection
