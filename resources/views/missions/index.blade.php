@extends('layouts.admin')
@section('title', 'Missions / Déplacements')
@section('page-title', 'Missions / Déplacements')

@section('content')
<div class="section-header">
    <div>
        <h2 class="page-title">Missions & Déplacements</h2>
        <p class="page-subtitle">{{ $missions->total() }} mission(s)</p>
    </div>
    <a href="{{ route('missions.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nouvelle mission
    </a>
</div>

<div class="card mb-4 p-4">
    <form method="GET" class="flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Référence, destination…" class="form-input w-56">
        <select name="statut" class="form-select w-40">
            <option value="">Tous statuts</option>
            <option value="planifiee" @selected(request('statut')=='planifiee')>Planifiée</option>
            <option value="en_cours" @selected(request('statut')=='en_cours')>En cours</option>
            <option value="terminee" @selected(request('statut')=='terminee')>Terminée</option>
            <option value="annulee" @selected(request('statut')=='annulee')>Annulée</option>
        </select>
        <button type="submit" class="btn-secondary">Filtrer</button>
        @if(request()->hasAny(['search','statut']))<a href="{{ route('missions.index') }}" class="btn-secondary">Réinitialiser</a>@endif
    </form>
</div>

<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200 text-xs text-gray-500 font-medium uppercase tracking-wider">
            <tr>
                <th class="px-4 py-3 text-left">Référence</th>
                <th class="px-4 py-3 text-left">Destination</th>
                <th class="px-4 py-3 text-left">Véhicule</th>
                <th class="px-4 py-3 text-left">Chauffeur</th>
                <th class="px-4 py-3 text-left">Départ</th>
                <th class="px-4 py-3 text-left">Retour prévu</th>
                <th class="px-4 py-3 text-right">Km parcourus</th>
                <th class="px-4 py-3 text-left">Statut</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($missions as $msn)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-mono text-xs font-medium text-gray-900">{{ $msn->reference }}</td>
                <td class="px-4 py-3">
                    <p class="font-medium text-gray-900">{{ Str::limit($msn->destination, 30) }}</p>
                    <p class="text-xs text-gray-400">{{ Str::limit($msn->objet, 35) }}</p>
                </td>
                <td class="px-4 py-3 font-mono text-gray-700">{{ $msn->vehicule->immatriculation }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $msn->chauffeur->name }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $msn->date_depart->format('d/m/Y') }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $msn->date_retour_prevue->format('d/m/Y') }}</td>
                <td class="px-4 py-3 text-right text-gray-700 font-medium">
                    {{ $msn->getKmParcourus() ? number_format($msn->getKmParcourus(),0,',',' ').' km' : '—' }}
                </td>
                <td class="px-4 py-3"><span class="badge {{ $msn->statut_class }}">{{ $msn->statut_libelle }}</span></td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('missions.show', $msn) }}" class="text-gray-400 hover:text-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        <a href="{{ route('missions.edit', $msn) }}" class="text-gray-400 hover:text-blue-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="9" class="px-4 py-8 text-center text-gray-400">Aucune mission trouvée</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3 border-t border-gray-100">{{ $missions->links() }}</div>
</div>
@endsection
