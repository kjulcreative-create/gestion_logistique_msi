@extends('layouts.admin')
@section('title', 'Consommation carburant')
@section('page-title', 'Consommation carburant')

@section('content')
<div class="max-w-xl">
<div class="card p-6">
    <dl class="space-y-3 text-sm">
        <div class="flex justify-between"><dt class="text-gray-500">Véhicule</dt><dd class="font-mono font-bold">{{ $carburant->vehicule->immatriculation }}</dd></div>
        <div class="flex justify-between"><dt class="text-gray-500">Date</dt><dd>{{ $carburant->date->format('d/m/Y') }}</dd></div>
        <div class="flex justify-between"><dt class="text-gray-500">Quantité</dt><dd class="font-bold">{{ $carburant->quantite_litres }} litres</dd></div>
        <div class="flex justify-between"><dt class="text-gray-500">Prix/litre</dt><dd>{{ number_format($carburant->prix_litre,0) }} FCFA</dd></div>
        <div class="flex justify-between font-bold border-t pt-2"><dt>Montant total</dt><dd class="text-emerald-700">{{ number_format($carburant->montant_total,0,',',' ') }} FCFA</dd></div>
        <div class="flex justify-between border-t pt-2"><dt class="text-gray-500">Station</dt><dd>{{ $carburant->station ?? '—' }}</dd></div>
        <div class="flex justify-between"><dt class="text-gray-500">Km compteur</dt><dd>{{ $carburant->km_compteur ? number_format($carburant->km_compteur,0,',',' ').' km' : '—' }}</dd></div>
        <div class="flex justify-between"><dt class="text-gray-500">Mission</dt><dd>{{ $carburant->mission?->reference ?? '—' }}</dd></div>
        <div class="flex justify-between"><dt class="text-gray-500">Saisi par</dt><dd>{{ $carburant->user->name }}</dd></div>
    </dl>
</div>
<div class="mt-4"><a href="{{ route('carburant.index') }}" class="btn-secondary">← Retour à la liste</a></div>
</div>
@endsection
