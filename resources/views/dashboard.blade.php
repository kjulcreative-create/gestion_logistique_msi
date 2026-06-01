@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')

@section('content')

{{-- ===== BANNIÈRE D'ACCUEIL DÉMO ===== --}}
<div id="demo-banner" class="bg-gradient-to-r from-emerald-700 to-emerald-600 rounded-xl p-5 mb-6 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <svg width="100%" height="100%" viewBox="0 0 400 120" preserveAspectRatio="xMidYMid slice">
            <circle cx="350" cy="-20" r="120" fill="white"/>
            <circle cx="50" cy="130" r="80" fill="white"/>
        </svg>
    </div>
    <div class="relative flex items-start justify-between gap-4">
        <div class="flex-1">
            <div class="flex items-center gap-2 mb-1">
                <span class="bg-white/20 text-white text-xs font-semibold px-2.5 py-0.5 rounded-full">Version démo</span>
                <span class="bg-white/20 text-white text-xs font-semibold px-2.5 py-0.5 rounded-full">MSI BF/LOG 2026/001</span>
            </div>
            <h2 class="text-xl font-bold mt-2 mb-1">Bienvenue, {{ auth()->user()->name }} 👋</h2>
            <p class="text-emerald-100 text-sm">Vous êtes connecté en tant que <strong>{{ auth()->user()->role_libelle }}</strong>. Ce système couvre 4 modules : Achats, Stocks, Équipements et Parc automobile.</p>
        </div>
        <button onclick="document.getElementById('demo-banner').remove()" class="text-white/60 hover:text-white flex-shrink-0 mt-1" title="Fermer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
</div>

{{-- ===== GUIDE DE DÉMARRAGE RAPIDE ===== --}}
<div id="guide-demarrage" class="card p-5 mb-6">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 bg-emerald-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
            </div>
            <h3 class="font-semibold text-gray-900">Guide de démarrage rapide</h3>
        </div>
        <button onclick="document.getElementById('guide-demarrage').remove()" class="text-gray-300 hover:text-gray-500 text-xs">Masquer</button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">

        {{-- Étape 1 — Achats --}}
        <a href="{{ route('commandes.index') }}" class="group border border-gray-200 hover:border-emerald-400 hover:bg-emerald-50 rounded-xl p-4 transition-all block">
            <div class="flex items-center gap-2 mb-3">
                <span class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 text-xs font-bold flex items-center justify-center flex-shrink-0">1</span>
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Module Achats</span>
            </div>
            <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <p class="text-sm font-semibold text-gray-900 mb-1">Bons de commande</p>
            <p class="text-xs text-gray-500">Consultez les {{ $stats['commandes_cours'] }} commande(s) en cours, créez-en une nouvelle ou suivez les livraisons fournisseurs.</p>
            <p class="text-xs text-emerald-600 font-medium mt-2 group-hover:underline">Voir les commandes →</p>
        </a>

        {{-- Étape 2 — Stocks --}}
        <a href="{{ route('articles.index') }}" class="group border border-gray-200 hover:border-blue-400 hover:bg-blue-50 rounded-xl p-4 transition-all block">
            <div class="flex items-center gap-2 mb-3">
                <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 text-xs font-bold flex items-center justify-center flex-shrink-0">2</span>
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Module Stocks</span>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <p class="text-sm font-semibold text-gray-900 mb-1">Articles & inventaire</p>
            <p class="text-xs text-gray-500">{{ $stats['articles'] }} articles en stock.
                @if($stats['articles_alerte'] > 0)
                <span class="text-red-600 font-medium">{{ $stats['articles_alerte'] }} article(s) en dessous du seuil d'alerte !</span>
                @else
                Tous les niveaux sont satisfaisants.
                @endif
            </p>
            <p class="text-xs text-blue-600 font-medium mt-2 group-hover:underline">Gérer le stock →</p>
        </a>

        {{-- Étape 3 — Équipements --}}
        <a href="{{ route('equipements.index') }}" class="group border border-gray-200 hover:border-purple-400 hover:bg-purple-50 rounded-xl p-4 transition-all block">
            <div class="flex items-center gap-2 mb-3">
                <span class="w-6 h-6 rounded-full bg-purple-100 text-purple-700 text-xs font-bold flex items-center justify-center flex-shrink-0">3</span>
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Équipements</span>
            </div>
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg>
            </div>
            <p class="text-sm font-semibold text-gray-900 mb-1">Patrimoine & matériel</p>
            <p class="text-xs text-gray-500">{{ $stats['equipements'] }} équipements enregistrés.
                @if($stats['equipements_maint'] > 0)
                <span class="text-amber-600 font-medium">{{ $stats['equipements_maint'] }} en maintenance.</span>
                @else
                Tous opérationnels.
                @endif
            </p>
            <p class="text-xs text-purple-600 font-medium mt-2 group-hover:underline">Voir les équipements →</p>
        </a>

        {{-- Étape 4 — Parc auto --}}
        <a href="{{ route('vehicules.index') }}" class="group border border-gray-200 hover:border-emerald-400 hover:bg-emerald-50 rounded-xl p-4 transition-all block">
            <div class="flex items-center gap-2 mb-3">
                <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold flex items-center justify-center flex-shrink-0">4</span>
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Parc automobile</span>
            </div>
            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17H5a2 2 0 01-2-2V8a2 2 0 012-2h3m5 10h3a2 2 0 002-2V8a2 2 0 00-2-2h-3m-5 0V4a1 1 0 011-1h4a1 1 0 011 1v3M8 17v-5h8v5"/></svg>
            </div>
            <p class="text-sm font-semibold text-gray-900 mb-1">Véhicules & missions</p>
            <p class="text-xs text-gray-500">{{ $stats['vehicules_dispo'] }}/{{ $stats['vehicules'] }} véhicules disponibles.
                @if($stats['missions_cours'] > 0)
                <span class="text-blue-600 font-medium">{{ $stats['missions_cours'] }} mission(s) en cours.</span>
                @endif
            </p>
            <p class="text-xs text-emerald-600 font-medium mt-2 group-hover:underline">Gérer la flotte →</p>
        </a>
    </div>

    {{-- Actions rapides --}}
    <div class="mt-4 pt-4 border-t border-gray-100">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Actions rapides</p>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('commandes.create') }}" class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 bg-amber-100 text-amber-700 rounded-lg hover:bg-amber-200 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nouvelle commande
            </a>
            <a href="{{ route('mouvements.create') }}" class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                Mouvement de stock
            </a>
            <a href="{{ route('missions.create') }}" class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 bg-emerald-100 text-emerald-700 rounded-lg hover:bg-emerald-200 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                Planifier une mission
            </a>
            <a href="{{ route('carburant.create') }}" class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Saisir du carburant
            </a>
            <a href="{{ route('fournisseurs.index') }}" class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
                Voir les fournisseurs
            </a>
        </div>
    </div>
</div>

{{-- ===== STATS ===== --}}
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

{{-- ===== 3 COLONNES : ALERTES / COMMANDES / MISSIONS ===== --}}
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
                <p class="text-xs text-gray-400">seuil : {{ $art->seuil_alerte }}</p>
            </div>
        </div>
        @empty
        <div class="text-center py-6">
            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <p class="text-sm text-gray-400">Tous les stocks sont au-dessus du seuil</p>
        </div>
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
        <div class="text-center py-6">
            <p class="text-sm text-gray-400 mb-2">Aucune commande enregistrée</p>
            <a href="{{ route('commandes.create') }}" class="text-xs text-emerald-600 hover:underline font-medium">+ Créer la première commande</a>
        </div>
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
        <div class="text-center py-6">
            <p class="text-sm text-gray-400 mb-2">Aucune mission planifiée</p>
            <a href="{{ route('missions.create') }}" class="text-xs text-emerald-600 hover:underline font-medium">+ Planifier une mission</a>
        </div>
        @endforelse
    </div>
</div>

{{-- ===== DERNIERS MOUVEMENTS DE STOCK ===== --}}
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
                <tr>
                    <td colspan="6" class="py-8 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                            </div>
                            <p class="text-sm text-gray-400">Aucun mouvement enregistré</p>
                            <a href="{{ route('mouvements.create') }}" class="text-xs text-emerald-600 hover:underline font-medium">Enregistrer le premier mouvement</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
