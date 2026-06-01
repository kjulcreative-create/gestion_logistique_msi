@extends('layouts.admin')
@section('title', 'Parc automobile')
@section('page-title', 'Parc automobile')

@section('content')
<div class="section-header">
    <div>
        <h2 class="page-title">Parc automobile</h2>
        <p class="page-subtitle">{{ $vehicules->total() }} véhicule(s)</p>
    </div>
    <a href="{{ route('vehicules.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nouveau véhicule
    </a>
</div>

<div class="card mb-4 p-4">
    <form method="GET" class="flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Immatriculation, marque…" class="form-input w-52">
        <select name="statut" class="form-select w-44">
            <option value="">Tous les statuts</option>
            <option value="disponible" @selected(request('statut')=='disponible')>Disponible</option>
            <option value="en_mission" @selected(request('statut')=='en_mission')>En mission</option>
            <option value="en_maintenance" @selected(request('statut')=='en_maintenance')>En maintenance</option>
            <option value="hors_service" @selected(request('statut')=='hors_service')>Hors service</option>
        </select>
        <button type="submit" class="btn-secondary">Filtrer</button>
        @if(request()->hasAny(['search','statut']))<a href="{{ route('vehicules.index') }}" class="btn-secondary">Réinitialiser</a>@endif
    </form>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($vehicules as $v)
    <div class="card p-5 flex flex-col gap-3">
        <div class="flex items-start justify-between">
            <div>
                <p class="font-bold text-gray-900 text-lg font-mono">{{ $v->immatriculation }}</p>
                <p class="text-sm text-gray-600">{{ $v->marque }} {{ $v->modele }} {{ $v->annee }}</p>
            </div>
            <span class="badge {{ $v->statut_class }}">{{ $v->statut_libelle }}</span>
        </div>
        <div class="grid grid-cols-2 gap-2 text-sm">
            <div>
                <p class="text-xs text-gray-400">Kilométrage</p>
                <p class="font-medium">{{ number_format($v->kilometrage_actuel, 0, ',', ' ') }} km</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Carburant</p>
                <p class="font-medium capitalize">{{ $v->type_carburant }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Chauffeur</p>
                <p class="font-medium">{{ $v->chauffeur?->name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Affectation</p>
                <p class="font-medium text-xs">{{ $v->affectation ? Str::limit($v->affectation, 25) : '—' }}</p>
            </div>
        </div>
        @if($v->date_expiration_assurance && $v->date_expiration_assurance->diffInDays(now()) <= 30 && !$v->assuranceExpiree())
        <div class="text-xs text-amber-600 bg-amber-50 rounded px-2 py-1">⚠ Assurance expire le {{ $v->date_expiration_assurance->format('d/m/Y') }}</div>
        @endif
        @if($v->assuranceExpiree())
        <div class="text-xs text-red-600 bg-red-50 rounded px-2 py-1">⚠ Assurance EXPIRÉE ({{ $v->date_expiration_assurance->format('d/m/Y') }})</div>
        @endif
        <div class="flex gap-2 pt-1 border-t border-gray-100">
            <a href="{{ route('vehicules.show', $v) }}" class="btn-secondary flex-1 justify-center text-xs py-1.5">Voir détail</a>
            <a href="{{ route('vehicules.edit', $v) }}" class="btn-secondary flex-1 justify-center text-xs py-1.5">Modifier</a>
        </div>
    </div>
    @empty
    <div class="lg:col-span-3 card p-8 text-center text-gray-400">Aucun véhicule enregistré</div>
    @endforelse
</div>
<div class="mt-4">{{ $vehicules->links() }}</div>
@endsection
