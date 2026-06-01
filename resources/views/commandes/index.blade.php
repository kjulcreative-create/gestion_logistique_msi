@extends('layouts.admin')
@section('title', 'Bons de commande')
@section('page-title', 'Bons de commande')

@section('content')
<div class="section-header">
    <div>
        <h2 class="page-title">Bons de commande</h2>
        <p class="page-subtitle">{{ $commandes->total() }} commande(s)</p>
    </div>
    <a href="{{ route('commandes.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nouvelle commande
    </a>
</div>

<div class="card mb-4 p-4">
    <form method="GET" class="flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Référence…" class="form-input w-48">
        <select name="statut" class="form-select w-44">
            <option value="">Tous statuts</option>
            <option value="brouillon" @selected(request('statut')=='brouillon')>Brouillon</option>
            <option value="validee" @selected(request('statut')=='validee')>Validée</option>
            <option value="en_cours" @selected(request('statut')=='en_cours')>En cours</option>
            <option value="livree" @selected(request('statut')=='livree')>Livrée</option>
            <option value="annulee" @selected(request('statut')=='annulee')>Annulée</option>
        </select>
        <button type="submit" class="btn-secondary">Filtrer</button>
        @if(request()->hasAny(['search','statut']))<a href="{{ route('commandes.index') }}" class="btn-secondary">Réinitialiser</a>@endif
    </form>
</div>

<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200 text-xs text-gray-500 font-medium uppercase tracking-wider">
            <tr>
                <th class="px-4 py-3 text-left">Référence</th>
                <th class="px-4 py-3 text-left">Fournisseur</th>
                <th class="px-4 py-3 text-left">Date commande</th>
                <th class="px-4 py-3 text-left">Livraison prévue</th>
                <th class="px-4 py-3 text-right">Montant</th>
                <th class="px-4 py-3 text-left">Statut</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($commandes as $cmd)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-mono font-medium text-gray-900">{{ $cmd->reference }}</td>
                <td class="px-4 py-3 text-gray-700">{{ $cmd->fournisseur->nom }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $cmd->date_commande->format('d/m/Y') }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $cmd->date_livraison_prevue?->format('d/m/Y') ?? '—' }}</td>
                <td class="px-4 py-3 text-right font-medium">{{ number_format($cmd->montant_total, 0, ',', ' ') }} FCFA</td>
                <td class="px-4 py-3"><span class="badge {{ $cmd->statut_class }}">{{ $cmd->statut_libelle }}</span></td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('commandes.show', $cmd) }}" class="text-gray-400 hover:text-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        <a href="{{ route('commandes.edit', $cmd) }}" class="text-gray-400 hover:text-blue-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-4 py-8 text-center text-gray-400">Aucune commande</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3 border-t border-gray-100">{{ $commandes->links() }}</div>
</div>
@endsection
