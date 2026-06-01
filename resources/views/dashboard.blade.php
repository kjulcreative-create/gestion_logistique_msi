@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')

@section('content')
{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="stat-card">
        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['articles'] }}</p>
            <p class="text-sm text-gray-500">Articles en stock</p>
            @if($stats['articles_alerte'] > 0)
            <p class="text-xs text-red-600 font-medium mt-0.5">⚠ {{ $stats['articles_alerte'] }} en alerte</p>
            @endif
        </div>
    </div>

    <div class="stat-card">
        <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['commandes_cours'] }}</p>
            <p class="text-sm text-gray-500">Commandes en cours</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['equipements'] }}</p>
            <p class="text-sm text-gray-500">Équipements</p>
            @if($stats['equipements_maint'] > 0)
            <p class="text-xs text-amber-600 font-medium mt-0.5">{{ $stats['equipements_maint'] }} en maintenance</p>
            @endif
        </div>
    </div>

    <div class="stat-card">
        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17H5a2 2 0 01-2-2V8a2 2 0 012-2h3m5 10h3a2 2 0 002-2V8a2 2 0 00-2-2h-3m-5 0V4a1 1 0 011-1h4a1 1 0 011 1v3M8 17v-5h8v5"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['vehicules_dispo'] }}/{{ $stats['vehicules'] }}</p>
            <p class="text-sm text-gray-500">Véhicules disponibles</p>
            @if($stats['missions_cours'] > 0)
            <p class="text-xs text-blue-600 font-medium mt-0.5">{{ $stats['missions_cours'] }} en mission</p>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="card p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                Alertes de stock
            </h3>
            <a href="{{ route('articles.index', ['alerte' => '1']) }}" class="text-xs text-emerald-600 hover:underline">Voir tout</a>
        </div>
        @forelse($articlesAlerte as $art)
        <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
            <div class="min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">{{ $art->designation }}</p>
                <p class="text-xs text-gray-500">{{ $art->categorie?->nom ?? '—' }}</p>
            </div>
            <div class="text-right flex-shrink-0 ml-3">
                <p class="text-sm font-bold text-red-600">{{ $art->quantite_stock }} {{ $art->unite }}</p>
                <p class="text-xs text-gray-400">seuil: {{ $art->seuil_alerte }}</p>
            </div>
        </div>
        @empty
        <p class="text-sm text-gray-400 text-center py-4">Aucune alerte de stock</p>
        @endforelse
    </div>

    <div class="card p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900">Commandes récentes</h3>
            <a href="{{ route('commandes.index') }}" class="text-xs text-emerald-600 hover:underline">Voir tout</a>
        </div>
        @forelse($commandesRecentes as $cmd)
        <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
            <div class="min-w-0">
                <a href="{{ route('commandes.show', $cmd) }}" class="text-sm font-medium text-gray-900 hover:text-emerald-600">{{ $cmd->reference }}</a>
                <p class="text-xs text-gray-500 truncate">{{ $cmd->fournisseur->nom }}</p>
            </div>
            <span class="badge {{ $cmd->statut_class }} flex-shrink-0 ml-2">{{ $cmd->statut_libelle }}</span>
        </div>
        @empty
        <p class="text-sm text-gray-400 text-center py-4">Aucune commande</p>
        @endforelse
    </div>

    <div class="card p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900">Missions / Déplacements</h3>
            <a href="{{ route('missions.index') }}" class="text-xs text-emerald-600 hover:underline">Voir tout</a>
        </div>
        @forelse($missionsEnCours as $msn)
        <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
            <div class="min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">{{ $msn->destination }}</p>
                <p class="text-xs text-gray-500">{{ $msn->vehicule->immatriculation }} · {{ $msn->chauffeur->name }}</p>
            </div>
            <span class="badge {{ $msn->statut_class }} flex-shrink-0 ml-2">{{ $msn->statut_libelle }}</span>
        </div>
        @empty
        <p class="text-sm text-gray-400 text-center py-4">Aucune mission planifiée</p>
        @endforelse
    </div>
</div>

<div class="card p-5 mt-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-semibold text-gray-900">Derniers mouvements de stock</h3>
        <a href="{{ route('mouvements.index') }}" class="text-xs text-emerald-600 hover:underline">Voir tout</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
                    <th class="pb-2 pr-4 font-medium">Date</th>
                    <th class="pb-2 pr-4 font-medium">Article</th>
                    <th class="pb-2 pr-4 font-medium">Type</th>
                    <th class="pb-2 pr-4 font-medium text-right">Quantité</th>
                    <th class="pb-2 pr-4 font-medium">Motif</th>
                    <th class="pb-2 font-medium">Agent</th>
                </tr>
            </thead>
            <tbody>
                @forelse($derniersMovements as $mvt)
                <tr class="table-row">
                    <td class="py-2 pr-4 text-gray-500">{{ $mvt->date_mouvement->format('d/m/Y') }}</td>
                    <td class="py-2 pr-4 font-medium text-gray-900">{{ Str::limit($mvt->article->designation, 30) }}</td>
                    <td class="py-2 pr-4"><span class="badge {{ $mvt->type_class }}">{{ $mvt->type_libelle }}</span></td>
                    <td class="py-2 pr-4 text-right font-mono">{{ number_format($mvt->quantite, 0, ',', ' ') }}</td>
                    <td class="py-2 pr-4 text-gray-500">{{ Str::limit($mvt->motif, 35) }}</td>
                    <td class="py-2 text-gray-500">{{ $mvt->user->name }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="py-4 text-center text-gray-400">Aucun mouvement enregistré</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
