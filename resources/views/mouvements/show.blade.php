@extends('layouts.admin')
@section('title', 'Mouvement de stock')
@section('page-title', 'Détail mouvement de stock')

@section('content')
<div class="max-w-xl">
<div class="card p-6">
    <div class="flex items-center gap-3 mb-6">
        <span class="badge {{ $mouvement->type_class }} text-sm px-3 py-1.5">{{ $mouvement->type_libelle }}</span>
        <p class="text-gray-500 text-sm">{{ $mouvement->date_mouvement->format('d/m/Y') }}</p>
    </div>
    <dl class="space-y-3 text-sm">
        <div class="flex justify-between"><dt class="text-gray-500">Article</dt><dd class="font-medium"><a href="{{ route('articles.show', $mouvement->article) }}" class="text-emerald-600 hover:underline">{{ $mouvement->article->designation }}</a></dd></div>
        <div class="flex justify-between"><dt class="text-gray-500">Quantité</dt><dd class="font-bold text-lg">{{ number_format($mouvement->quantite, 2) }} {{ $mouvement->article->unite }}</dd></div>
        <div class="flex justify-between pt-2 border-t">
            <dt class="text-gray-500">Stock avant</dt><dd>{{ number_format($mouvement->quantite_avant, 2) }}</dd>
        </div>
        <div class="flex justify-between"><dt class="text-gray-500">Stock après</dt><dd class="font-bold">{{ number_format($mouvement->quantite_apres, 2) }}</dd></div>
        <div class="flex justify-between pt-2 border-t"><dt class="text-gray-500">Motif</dt><dd class="font-medium">{{ $mouvement->motif }}</dd></div>
        <div class="flex justify-between"><dt class="text-gray-500">Référence doc.</dt><dd class="font-mono text-xs">{{ $mouvement->reference_doc ?? '—' }}</dd></div>
        <div class="flex justify-between"><dt class="text-gray-500">Agent</dt><dd>{{ $mouvement->user->name }}</dd></div>
        @if($mouvement->notes)
        <div class="pt-2 border-t"><dt class="text-gray-500 mb-1">Notes</dt><dd class="text-gray-700">{{ $mouvement->notes }}</dd></div>
        @endif
    </dl>
</div>
<div class="mt-4"><a href="{{ route('mouvements.index') }}" class="btn-secondary">← Retour à la liste</a></div>
</div>
@endsection
