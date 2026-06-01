@extends('layouts.admin')
@section('title', 'Nouvelle consommation carburant')
@section('page-title', 'Nouvelle consommation carburant')

@section('content')
<div class="max-w-xl">
<form method="POST" action="{{ route('carburant.store') }}">
    @csrf
    <div class="card p-6 space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Véhicule <span class="text-red-500">*</span></label>
                <select name="vehicule_id" class="form-select" required>
                    <option value="">— Sélectionner —</option>
                    @foreach($vehicules as $v)
                    <option value="{{ $v->id }}" @selected(old('vehicule_id',request('vehicule_id'))==$v->id)>
                        {{ $v->immatriculation }} — {{ $v->marque }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Date <span class="text-red-500">*</span></label>
                <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" class="form-input" required>
            </div>
        </div>

        <div>
            <label class="form-label">Mission associée (optionnel)</label>
            <select name="mission_id" class="form-select">
                <option value="">— Aucune mission —</option>
                @foreach($missions as $msn)
                <option value="{{ $msn->id }}" @selected(old('mission_id',request('mission_id'))==$msn->id)>
                    {{ $msn->reference }} — {{ $msn->destination }} ({{ $msn->vehicule->immatriculation }})
                </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Quantité (litres) <span class="text-red-500">*</span></label>
                <input type="number" name="quantite_litres" value="{{ old('quantite_litres') }}" class="form-input" step="0.1" min="1" required placeholder="50">
            </div>
            <div>
                <label class="form-label">Prix au litre (FCFA) <span class="text-red-500">*</span></label>
                <input type="number" name="prix_litre" value="{{ old('prix_litre', 700) }}" class="form-input" step="1" min="1" required>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Station</label>
                <input type="text" name="station" value="{{ old('station') }}" class="form-input" placeholder="Total, Shell…">
            </div>
            <div>
                <label class="form-label">Km au compteur</label>
                <input type="number" name="km_compteur" value="{{ old('km_compteur') }}" class="form-input" min="0">
            </div>
        </div>

        <div>
            <label class="form-label">Notes</label>
            <textarea name="notes" rows="2" class="form-input">{{ old('notes') }}</textarea>
        </div>
    </div>

    <div class="flex gap-3 mt-4">
        <button type="submit" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Enregistrer
        </button>
        <a href="{{ route('carburant.index') }}" class="btn-secondary">Annuler</a>
    </div>
</form>
</div>
@endsection
