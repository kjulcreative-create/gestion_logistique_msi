@extends('layouts.admin')
@section('title', 'Articles & Stock')
@section('page-title', 'Articles & Stock')

@section('content')
<div class="section-header">
    <div>
        <h2 class="page-title">Articles & Stock</h2>
        <p class="page-subtitle">{{ $articles->total() }} article(s) · @if(request('alerte')=='1') <span class="text-red-600 font-medium">Affichage alertes uniquement</span>@endif</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('mouvements.create') }}" class="btn-secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
            Mouvement de stock
        </a>
        <a href="{{ route('articles.create') }}" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nouvel article
        </a>
    </div>
</div>

<div class="card mb-4 p-4">
    <form method="GET" class="flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Désignation ou code…" class="form-input max-w-xs">
        <select name="categorie_id" class="form-select w-48">
            <option value="">Toutes catégories</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" @selected(request('categorie_id') == $cat->id)>{{ $cat->nom }}</option>
            @endforeach
        </select>
        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
            <input type="checkbox" name="alerte" value="1" @checked(request('alerte')=='1') class="rounded border-gray-300 text-emerald-600">
            Alertes seulement
        </label>
        <button type="submit" class="btn-secondary">Filtrer</button>
        @if(request()->hasAny(['search','categorie_id','alerte']))
        <a href="{{ route('articles.index') }}" class="btn-secondary">Réinitialiser</a>
        @endif
    </form>
</div>

<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr class="text-left text-xs text-gray-500 font-medium uppercase tracking-wider">
                <th class="px-4 py-3">Code</th>
                <th class="px-4 py-3">Désignation</th>
                <th class="px-4 py-3">Catégorie</th>
                <th class="px-4 py-3">Localisation</th>
                <th class="px-4 py-3 text-right">Stock</th>
                <th class="px-4 py-3 text-right">Seuil</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($articles as $art)
            <tr class="hover:bg-gray-50 transition-colors {{ $art->estEnAlerte() ? 'bg-red-50' : '' }}">
                <td class="px-4 py-3 font-mono text-xs text-gray-500">{{ $art->code }}</td>
                <td class="px-4 py-3">
                    <a href="{{ route('articles.show', $art) }}" class="font-medium text-gray-900 hover:text-emerald-600">{{ $art->designation }}</a>
                    @if($art->estEnAlerte())
                    <span class="ml-2 badge bg-red-100 text-red-600">⚠ Alerte</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-gray-500">{{ $art->categorie?->nom ?? '—' }}</td>
                <td class="px-4 py-3 text-gray-500 text-xs">{{ $art->localisation ?? '—' }}</td>
                <td class="px-4 py-3 text-right font-bold {{ $art->estEnAlerte() ? 'text-red-600' : 'text-gray-900' }}">
                    {{ number_format($art->quantite_stock, 0, ',', ' ') }} {{ $art->unite }}
                </td>
                <td class="px-4 py-3 text-right text-gray-400 text-xs">{{ number_format($art->seuil_alerte, 0) }}</td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('articles.show', $art) }}" class="text-gray-400 hover:text-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        <a href="{{ route('articles.edit', $art) }}" class="text-gray-400 hover:text-blue-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-4 py-8 text-center text-gray-400">Aucun article trouvé</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3 border-t border-gray-100">{{ $articles->links() }}</div>
</div>
@endsection
