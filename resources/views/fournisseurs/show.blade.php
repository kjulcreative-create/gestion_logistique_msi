@extends('layouts.admin')
@section('title', $fournisseur->nom)
@section('page-title', $fournisseur->nom)
@section('breadcrumb')
    <span class="mx-1">/</span><a href="{{ route('fournisseurs.index') }}" class="hover:text-emerald-600">Fournisseurs</a>
    <span class="mx-1">/</span> {{ $fournisseur->nom }}
@endsection

@section('content')
<div class="section-header">
    <div>
        <h2 class="page-title">{{ $fournisseur->nom }}</h2>
        <p class="page-subtitle">{{ $fournisseur->code }} · {{ $fournisseur->type_fourniture ?? 'Type non défini' }}</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('fournisseurs.edit', $fournisseur) }}" class="btn-secondary">Modifier</a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="card p-5">
        <h3 class="font-semibold text-gray-900 mb-4">Coordonnées</h3>
        <dl class="space-y-3 text-sm">
            <div class="flex justify-between"><dt class="text-gray-500">Contact</dt><dd class="font-medium">{{ $fournisseur->contact ?? '—' }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Téléphone</dt><dd class="font-medium">{{ $fournisseur->telephone ?? '—' }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Email</dt><dd class="font-medium">{{ $fournisseur->email ?? '—' }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Ville</dt><dd class="font-medium">{{ $fournisseur->ville ?? '—' }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Pays</dt><dd class="font-medium">{{ $fournisseur->pays }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Adresse</dt><dd class="font-medium text-right max-w-xs">{{ $fournisseur->adresse ?? '—' }}</dd></div>
            <div class="flex justify-between pt-2 border-t"><dt class="text-gray-500">Statut</dt>
                <dd><span class="badge {{ $fournisseur->statut === 'actif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">{{ ucfirst($fournisseur->statut) }}</span></dd>
            </div>
        </dl>
    </div>

    <div class="card p-5">
        <h3 class="font-semibold text-gray-900 mb-4">Dernières commandes</h3>
        @forelse($commandes as $cmd)
        <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0 text-sm">
            <div>
                <a href="{{ route('commandes.show', $cmd) }}" class="font-medium text-gray-900 hover:text-emerald-600">{{ $cmd->reference }}</a>
                <p class="text-xs text-gray-500">{{ $cmd->date_commande->format('d/m/Y') }}</p>
            </div>
            <div class="text-right">
                <p class="font-medium">{{ number_format($cmd->montant_total, 0, ',', ' ') }} FCFA</p>
                <span class="badge {{ $cmd->statut_class }}">{{ $cmd->statut_libelle }}</span>
            </div>
        </div>
        @empty
        <p class="text-sm text-gray-400 py-4 text-center">Aucune commande passée</p>
        @endforelse
    </div>
</div>
@endsection
