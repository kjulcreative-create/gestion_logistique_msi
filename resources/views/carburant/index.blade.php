@extends('layouts.admin')
@section('title', 'Carburant')
@section('page-title', 'Suivi carburant')

@section('content')
<div class="section-header">
    <div>
        <h2 class="page-title">Suivi carburant</h2>
        <p class="page-subtitle">Dépense du mois en cours : <strong class="text-gray-900">{{ number_format($totalMois,0,',',' ') }} FCFA</strong></p>
    </div>
    <a href="{{ route('carburant.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nouvelle consommation
    </a>
</div>

<div class="card mb-4 p-4">
    <form method="GET" class="flex flex-wrap gap-3">
        <select name="vehicule_id" class="form-select w-56">
            <option value="">Tous les véhicules</option>
            @foreach($vehicules as $v)
            <option value="{{ $v->id }}" @selected(request('vehicule_id')==$v->id)>{{ $v->immatriculation }} — {{ $v->marque }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-secondary">Filtrer</button>
        @if(request('vehicule_id'))<a href="{{ route('carburant.index') }}" class="btn-secondary">Réinitialiser</a>@endif
    </form>
</div>

<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200 text-xs text-gray-500 font-medium uppercase tracking-wider">
            <tr>
                <th class="px-4 py-3 text-left">Date</th>
                <th class="px-4 py-3 text-left">Véhicule</th>
                <th class="px-4 py-3 text-right">Litres</th>
                <th class="px-4 py-3 text-right">Prix/L</th>
                <th class="px-4 py-3 text-right">Montant</th>
                <th class="px-4 py-3 text-left">Station</th>
                <th class="px-4 py-3 text-right">Km compteur</th>
                <th class="px-4 py-3 text-left">Agent</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($consommations as $c)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-gray-500">{{ $c->date->format('d/m/Y') }}</td>
                <td class="px-4 py-3 font-mono font-medium text-gray-900">{{ $c->vehicule->immatriculation }}</td>
                <td class="px-4 py-3 text-right font-medium">{{ $c->quantite_litres }} L</td>
                <td class="px-4 py-3 text-right text-gray-500">{{ number_format($c->prix_litre,0) }} F</td>
                <td class="px-4 py-3 text-right font-bold text-gray-900">{{ number_format($c->montant_total,0,',',' ') }} FCFA</td>
                <td class="px-4 py-3 text-gray-500">{{ $c->station ?? '—' }}</td>
                <td class="px-4 py-3 text-right text-gray-500">{{ $c->km_compteur ? number_format($c->km_compteur,0,',',' ') : '—' }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $c->user->name }}</td>
                <td class="px-4 py-3 text-right">
                    <form method="POST" action="{{ route('carburant.destroy', $c) }}" onsubmit="return confirm('Supprimer cet enregistrement ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-gray-400 hover:text-red-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="9" class="px-4 py-8 text-center text-gray-400">Aucune consommation enregistrée</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3 border-t border-gray-100">{{ $consommations->links() }}</div>
</div>
@endsection
