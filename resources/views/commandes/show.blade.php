@extends('layouts.admin')
@section('title', $commande->reference)
@section('page-title', 'Bon de commande')

@section('content')
<div class="section-header">
    <div>
        <h2 class="page-title">{{ $commande->reference }}</h2>
        <p class="page-subtitle">{{ $commande->fournisseur->nom }} · {{ $commande->date_commande->format('d/m/Y') }}</p>
    </div>
    <div class="flex gap-2">
        <span class="badge {{ $commande->statut_class }} text-sm px-3 py-1.5">{{ $commande->statut_libelle }}</span>
        <a href="{{ route('commandes.edit', $commande) }}" class="btn-secondary">Modifier</a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="card p-5 lg:col-span-2">
        <h3 class="font-semibold text-gray-900 mb-4">Lignes de commande</h3>
        <table class="w-full text-sm">
            <thead class="text-xs text-gray-500 border-b">
                <tr>
                    <th class="pb-2 text-left pr-4 font-medium">Article</th>
                    <th class="pb-2 text-right pr-4 font-medium">Qté commandée</th>
                    <th class="pb-2 text-right pr-4 font-medium">Qté reçue</th>
                    <th class="pb-2 text-right pr-4 font-medium">Prix unit.</th>
                    <th class="pb-2 text-right font-medium">Montant</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commande->lignes as $ligne)
                <tr class="table-row">
                    <td class="py-2 pr-4">
                        <p class="font-medium text-gray-900">{{ $ligne->article->designation }}</p>
                        <p class="text-xs text-gray-500">{{ $ligne->article->code }}</p>
                    </td>
                    <td class="py-2 pr-4 text-right">{{ number_format($ligne->quantite, 0) }} {{ $ligne->article->unite }}</td>
                    <td class="py-2 pr-4 text-right {{ $ligne->quantite_recue >= $ligne->quantite ? 'text-green-600 font-medium' : 'text-gray-500' }}">
                        {{ number_format($ligne->quantite_recue, 0) }}
                    </td>
                    <td class="py-2 pr-4 text-right font-mono">{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }}</td>
                    <td class="py-2 text-right font-medium">{{ number_format($ligne->montant_ligne, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="border-t-2 border-gray-200">
                <tr>
                    <td colspan="4" class="pt-3 text-right font-semibold text-gray-700">Total commande :</td>
                    <td class="pt-3 text-right font-bold text-gray-900 text-base">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="space-y-4">
        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 mb-3">Informations</h3>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-gray-500">Fournisseur</dt><dd class="font-medium text-right">{{ $commande->fournisseur->nom }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Date commande</dt><dd class="font-medium">{{ $commande->date_commande->format('d/m/Y') }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Livraison prévue</dt><dd class="font-medium">{{ $commande->date_livraison_prevue?->format('d/m/Y') ?? '—' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Livraison réelle</dt><dd class="font-medium">{{ $commande->date_livraison_reelle?->format('d/m/Y') ?? '—' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Créée par</dt><dd class="font-medium">{{ $commande->user->name }}</dd></div>
            </dl>
        </div>

        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 mb-3">Changer le statut</h3>
            <form method="POST" action="{{ route('commandes.statut', $commande) }}">
                @csrf @method('PATCH')
                <select name="statut" class="form-select mb-3">
                    @foreach(['brouillon'=>'Brouillon','validee'=>'Validée','en_cours'=>'En cours','livree'=>'Livrée','annulee'=>'Annulée'] as $val => $lib)
                    <option value="{{ $val }}" @selected($commande->statut === $val)>{{ $lib }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-primary w-full justify-center">Appliquer</button>
            </form>
        </div>

        @if($commande->notes)
        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 mb-2">Notes</h3>
            <p class="text-sm text-gray-600">{{ $commande->notes }}</p>
        </div>
        @endif
    </div>
</div>
@endsection
