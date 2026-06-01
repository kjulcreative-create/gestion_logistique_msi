@extends('layouts.admin')
@section('title', 'Équipements')
@section('page-title', 'Équipements')

@section('content')
<div class="section-header">
    <div>
        <h2 class="page-title">Équipements</h2>
        <p class="page-subtitle">{{ $equipements->total() }} équipement(s) enregistré(s)</p>
    </div>
    <a href="{{ route('equipements.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nouvel équipement
    </a>
</div>

<div class="card mb-4 p-4">
    <form method="GET" class="flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Désignation ou code…" class="form-input max-w-xs">
        <select name="statut" class="form-select w-44">
            <option value="">Tous les statuts</option>
            <option value="en_service" @selected(request('statut')=='en_service')>En service</option>
            <option value="en_maintenance" @selected(request('statut')=='en_maintenance')>En maintenance</option>
            <option value="hors_service" @selected(request('statut')=='hors_service')>Hors service</option>
            <option value="reforme" @selected(request('statut')=='reforme')>Réformé</option>
        </select>
        <button type="submit" class="btn-secondary">Filtrer</button>
        @if(request()->hasAny(['search','statut']))<a href="{{ route('equipements.index') }}" class="btn-secondary">Réinitialiser</a>@endif
    </form>
</div>

<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200 text-xs text-gray-500 font-medium uppercase tracking-wider">
            <tr>
                <th class="px-4 py-3 text-left">Code</th>
                <th class="px-4 py-3 text-left">Désignation</th>
                <th class="px-4 py-3 text-left">Marque / Modèle</th>
                <th class="px-4 py-3 text-left">Localisation</th>
                <th class="px-4 py-3 text-left">Responsable</th>
                <th class="px-4 py-3 text-left">Statut</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($equipements as $eq)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-mono text-xs text-gray-500">{{ $eq->code }}</td>
                <td class="px-4 py-3">
                    <a href="{{ route('equipements.show', $eq) }}" class="font-medium text-gray-900 hover:text-emerald-600">{{ $eq->designation }}</a>
                    @if($eq->numero_serie)<p class="text-xs text-gray-400">S/N: {{ $eq->numero_serie }}</p>@endif
                </td>
                <td class="px-4 py-3 text-gray-600">{{ $eq->marque }} {{ $eq->modele }}</td>
                <td class="px-4 py-3 text-gray-500 text-xs">{{ $eq->localisation ?? '—' }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $eq->responsable?->name ?? '—' }}</td>
                <td class="px-4 py-3"><span class="badge {{ $eq->statut_class }}">{{ $eq->statut_libelle }}</span></td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('equipements.show', $eq) }}" class="text-gray-400 hover:text-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        <a href="{{ route('equipements.edit', $eq) }}" class="text-gray-400 hover:text-blue-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-4 py-8 text-center text-gray-400">Aucun équipement trouvé</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3 border-t border-gray-100">{{ $equipements->links() }}</div>
</div>
@endsection
