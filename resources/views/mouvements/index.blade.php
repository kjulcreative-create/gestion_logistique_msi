@extends('layouts.admin')
@section('title', 'Mouvements de stock')
@section('page-title', 'Mouvements de stock')

@section('content')
<div class="section-header">
    <div>
        <h2 class="page-title">Mouvements de stock</h2>
        <p class="page-subtitle">Historique des entrées, sorties et ajustements</p>
    </div>
    <a href="{{ route('mouvements.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nouveau mouvement
    </a>
</div>

<div class="card mb-4 p-4">
    <form method="GET" class="flex flex-wrap gap-3">
        <select name="type" class="form-select w-40">
            <option value="">Tous les types</option>
            <option value="entree" @selected(request('type')=='entree')>Entrée</option>
            <option value="sortie" @selected(request('type')=='sortie')>Sortie</option>
            <option value="ajustement" @selected(request('type')=='ajustement')>Ajustement</option>
        </select>
        <select name="article_id" class="form-select w-64">
            <option value="">Tous les articles</option>
            @foreach($articles as $art)
            <option value="{{ $art->id }}" @selected(request('article_id') == $art->id)>{{ $art->designation }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-secondary">Filtrer</button>
        @if(request()->hasAny(['type','article_id']))
        <a href="{{ route('mouvements.index') }}" class="btn-secondary">Réinitialiser</a>
        @endif
    </form>
</div>

<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200 text-xs text-gray-500 font-medium uppercase tracking-wider">
            <tr>
                <th class="px-4 py-3 text-left">Date</th>
                <th class="px-4 py-3 text-left">Article</th>
                <th class="px-4 py-3 text-left">Type</th>
                <th class="px-4 py-3 text-right">Quantité</th>
                <th class="px-4 py-3 text-right">Avant</th>
                <th class="px-4 py-3 text-right">Après</th>
                <th class="px-4 py-3 text-left">Motif</th>
                <th class="px-4 py-3 text-left">Référence</th>
                <th class="px-4 py-3 text-left">Agent</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($mouvements as $mvt)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-gray-500">{{ $mvt->date_mouvement->format('d/m/Y') }}</td>
                <td class="px-4 py-3">
                    <a href="{{ route('articles.show', $mvt->article) }}" class="font-medium text-gray-900 hover:text-emerald-600">{{ Str::limit($mvt->article->designation, 35) }}</a>
                </td>
                <td class="px-4 py-3"><span class="badge {{ $mvt->type_class }}">{{ $mvt->type_libelle }}</span></td>
                <td class="px-4 py-3 text-right font-bold font-mono">{{ number_format($mvt->quantite, 0) }}</td>
                <td class="px-4 py-3 text-right text-gray-400 font-mono">{{ number_format($mvt->quantite_avant, 0) }}</td>
                <td class="px-4 py-3 text-right text-gray-700 font-mono">{{ number_format($mvt->quantite_apres, 0) }}</td>
                <td class="px-4 py-3 text-gray-500">{{ Str::limit($mvt->motif, 35) }}</td>
                <td class="px-4 py-3 text-gray-400 text-xs font-mono">{{ $mvt->reference_doc ?? '—' }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $mvt->user->name }}</td>
            </tr>
            @empty
            <tr><td colspan="9" class="px-4 py-8 text-center text-gray-400">Aucun mouvement trouvé</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3 border-t border-gray-100">{{ $mouvements->links() }}</div>
</div>
@endsection
