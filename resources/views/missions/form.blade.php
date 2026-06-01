@extends('layouts.admin')
@section('title', $mission->exists ? 'Modifier mission' : 'Nouvelle mission')
@section('page-title', $mission->exists ? 'Modifier mission' : 'Nouvelle mission')

@section('content')
<div class="max-w-2xl">
<form method="POST" action="{{ $mission->exists ? route('missions.update', $mission) : route('missions.store') }}">
    @csrf
    @if($mission->exists) @method('PUT') @endif

    <div class="card p-6 space-y-4 mb-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Référence <span class="text-red-500">*</span></label>
                <input type="text" name="reference" value="{{ old('reference', $mission->reference ?? 'MSN-'.date('Y').'-') }}" class="form-input" required>
                @error('reference')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label">Statut</label>
                <select name="statut" class="form-select">
                    <option value="planifiee" @selected(old('statut',$mission->statut??'planifiee')==='planifiee')>Planifiée</option>
                    <option value="en_cours" @selected(old('statut',$mission->statut)==='en_cours')>En cours</option>
                    <option value="terminee" @selected(old('statut',$mission->statut)==='terminee')>Terminée</option>
                    <option value="annulee" @selected(old('statut',$mission->statut)==='annulee')>Annulée</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Véhicule <span class="text-red-500">*</span></label>
                <select name="vehicule_id" class="form-select" required>
                    <option value="">— Sélectionner —</option>
                    @foreach($vehicules as $v)
                    <option value="{{ $v->id }}" @selected(old('vehicule_id',request('vehicule_id'),$mission->vehicule_id)==$v->id)>
                        {{ $v->immatriculation }} — {{ $v->marque }} {{ $v->modele }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Chauffeur <span class="text-red-500">*</span></label>
                <select name="chauffeur_id" class="form-select" required>
                    <option value="">— Sélectionner —</option>
                    @foreach($chauffeurs as $c)
                    <option value="{{ $c->id }}" @selected(old('chauffeur_id',$mission->chauffeur_id)==$c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="form-label">Destination <span class="text-red-500">*</span></label>
            <input type="text" name="destination" value="{{ old('destination', $mission->destination) }}" class="form-input" required>
        </div>
        <div>
            <label class="form-label">Objet de la mission <span class="text-red-500">*</span></label>
            <textarea name="objet" rows="2" class="form-input" required>{{ old('objet', $mission->objet) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Date de départ <span class="text-red-500">*</span></label>
                <input type="date" name="date_depart" value="{{ old('date_depart', $mission->date_depart?->format('Y-m-d') ?? date('Y-m-d')) }}" class="form-input" required>
            </div>
            <div>
                <label class="form-label">Heure de départ</label>
                <input type="time" name="heure_depart" value="{{ old('heure_depart', $mission->heure_depart ?? '07:00') }}" class="form-input">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Date de retour prévue <span class="text-red-500">*</span></label>
                <input type="date" name="date_retour_prevue" value="{{ old('date_retour_prevue', $mission->date_retour_prevue?->format('Y-m-d')) }}" class="form-input" required>
            </div>
            @if($mission->exists)
            <div>
                <label class="form-label">Date de retour réelle</label>
                <input type="date" name="date_retour_reelle" value="{{ old('date_retour_reelle', $mission->date_retour_reelle?->format('Y-m-d')) }}" class="form-input">
            </div>
            @endif
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Km au départ</label>
                <input type="number" name="km_depart" value="{{ old('km_depart', $mission->km_depart) }}" class="form-input" min="0">
            </div>
            @if($mission->exists)
            <div>
                <label class="form-label">Km au retour</label>
                <input type="number" name="km_retour" value="{{ old('km_retour', $mission->km_retour) }}" class="form-input" min="0">
            </div>
            @endif
        </div>

        <div>
            <label class="form-label">Observations</label>
            <textarea name="observations" rows="2" class="form-input">{{ old('observations', $mission->observations) }}</textarea>
        </div>
    </div>

    <div class="flex gap-3">
        <button type="submit" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ $mission->exists ? 'Mettre à jour' : 'Créer la mission' }}
        </button>
        <a href="{{ route('missions.index') }}" class="btn-secondary">Annuler</a>
    </div>
</form>
</div>
@endsection
