@extends('layouts.admin')
@section('title', $article->designation)
@section('page-title', $article->designation)

@section('content')
<div class="section-header">
    <div>
        <h2 class="page-title">{{ $article->designation }}</h2>
        <p class="page-subtitle">{{ $article->code }} · {{ $article->categorie?->nom ?? 'Sans catégorie' }}</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('mouvements.create', ['article_id' => $article->id]) }}" class="btn-secondary">Mouvement de stock</a>
        <a href="{{ route('articles.edit', $article) }}" class="btn-primary">Modifier</a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="stat-card">
        <div class="w-12 h-12 {{ $article->estEnAlerte() ? 'bg-red-100' : 'bg-blue-100' }} rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 {{ $article->estEnAlerte() ? 'text-red-600' : 'text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold {{ $article->estEnAlerte() ? 'text-red-600' : 'text-gray-900' }}">{{ number_format($article->quantite_stock, 2, ',', ' ') }}</p>
            <p class="text-sm text-gray-500">Stock actuel ({{ $article->unite }})</p>
            @if($article->estEnAlerte())<p class="text-xs text-red-600 font-medium">⚠ Seuil d'alerte atteint</p>@endif
        </div>
    </div>
    <div class="stat-card">
        <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($article->seuil_alerte, 0) }}</p>
            <p class="text-sm text-gray-500">Seuil d'alerte</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ $article->prix_unitaire ? number_format($article->prix_unitaire, 0, ',', ' ').' FCFA' : '—' }}</p>
            <p class="text-sm text-gray-500">Prix unitaire</p>
        </div>
    </div>
</div>

<div class="card p-5">
    <h3 class="font-semibold text-gray-900 mb-4">Historique des mouvements</h3>
    <table class="w-full text-sm">
        <thead class="text-xs text-gray-500 border-b">
            <tr>
                <th class="pb-2 text-left pr-4 font-medium">Date</th>
                <th class="pb-2 text-left pr-4 font-medium">Type</th>
                <th class="pb-2 text-right pr-4 font-medium">Quantité</th>
                <th class="pb-2 text-right pr-4 font-medium">Avant</th>
                <th class="pb-2 text-right pr-4 font-medium">Après</th>
                <th class="pb-2 text-left pr-4 font-medium">Motif</th>
                <th class="pb-2 text-left font-medium">Agent</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mouvements as $mvt)
            <tr class="table-row">
                <td class="py-2 pr-4 text-gray-500">{{ $mvt->date_mouvement->format('d/m/Y') }}</td>
                <td class="py-2 pr-4"><span class="badge {{ $mvt->type_class }}">{{ $mvt->type_libelle }}</span></td>
                <td class="py-2 pr-4 text-right font-mono font-bold">{{ $mvt->type === 'sortie' ? '-' : '+' }}{{ number_format($mvt->quantite, 0) }}</td>
                <td class="py-2 pr-4 text-right text-gray-400">{{ number_format($mvt->quantite_avant, 0) }}</td>
                <td class="py-2 pr-4 text-right text-gray-700">{{ number_format($mvt->quantite_apres, 0) }}</td>
                <td class="py-2 pr-4 text-gray-500">{{ $mvt->motif }}</td>
                <td class="py-2 text-gray-500">{{ $mvt->user->name }}</td>
            </tr>
            @empty
            <tr><td colspan="7" class="py-4 text-center text-gray-400">Aucun mouvement enregistré</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
