@extends('layouts.admin')
@section('title', $vehicule->exists ? 'Modifier véhicule' : 'Nouveau véhicule')
@section('page-title', $vehicule->exists ? 'Modifier véhicule' : 'Nouveau véhicule')

@section('content')
<div class="max-w-2xl">
<form method="POST" action="{{ $vehicule->exists ? route('vehicules.update', $vehicule) : route('vehicules.store') }}">
    @csrf
    @if($vehicule->exists) @method('PUT') @endif

    <div class="card p-6 space-y-4 mb-4">
        <h3 class="font-semibold text-gray-900 border-b pb-3">Identification du véhicule</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Immatriculation <span class="text-red-500">*</span></label>
                <input type="text" name="immatriculation" value="{{ old('immatriculation', $vehicule->immatriculation) }}" class="form-input uppercase" required placeholder="11A1234BF">
                @error('immatriculation')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label">Statut <span class="text-red-500">*</span></label>
                <select name="statut" class="form-select" required>
                    <option value="disponible" @selected(old('statut',$vehicule->statut??'disponible')==='disponible')>Disponible</option>
                    <option value="en_mission" @selected(old('statut',$vehicule->statut)==='en_mission')>En mission</option>
                    <option value="en_maintenance" @selected(old('statut',$vehicule->statut)==='en_maintenance')>En maintenance</option>
                    <option value="hors_service" @selected(old('statut',$vehicule->statut)==='hors_service')>Hors service</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="form-label">Marque <span class="text-red-500">*</span></label>
                <input type="text" name="marque" value="{{ old('marque', $vehicule->marque) }}" class="form-input" required placeholder="Toyota">
            </div>
            <div>
                <label class="form-label">Modèle <span class="text-red-500">*</span></label>
                <input type="text" name="modele" value="{{ old('modele', $vehicule->modele) }}" class="form-input" required>
            </div>
            <div>
                <label class="form-label">Année <span class="text-red-500">*</span></label>
                <input type="number" name="annee" value="{{ old('annee', $vehicule->annee ?? date('Y')) }}" class="form-input" required min="2000" max="2030">
            </div>
        </div>
        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="form-label">Carburant</label>
                <select name="type_carburant" class="form-select">
                    <option value="diesel" @selected(old('type_carburant',$vehicule->type_carburant??'diesel')==='diesel')>Diesel</option>
                    <option value="essence" @selected(old('type_carburant',$vehicule->type_carburant)==='essence')>Essence</option>
                    <option value="hybride" @selected(old('type_carburant',$vehicule->type_carburant)==='hybride')>Hybride</option>
                    <option value="electrique" @selected(old('type_carburant',$vehicule->type_carburant)==='electrique')>Électrique</option>
                </select>
            </div>
            <div>
                <label class="form-label">Couleur</label>
                <input type="text" name="couleur" value="{{ old('couleur', $vehicule->couleur) }}" class="form-input">
            </div>
            <div>
                <label class="form-label">Kilométrage actuel <span class="text-red-500">*</span></label>
                <input type="number" name="kilometrage_actuel" value="{{ old('kilometrage_actuel', $vehicule->kilometrage_actuel ?? 0) }}" class="form-input" min="0" required>
            </div>
        </div>
        <div>
            <label class="form-label">Numéro de châssis</label>
            <input type="text" name="numero_chassis" value="{{ old('numero_chassis', $vehicule->numero_chassis) }}" class="form-input font-mono">
        </div>
    </div>

    <div class="card p-6 space-y-4 mb-4">
        <h3 class="font-semibold text-gray-900 border-b pb-3">Affectation & Documents</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Chauffeur attitré</label>
                <select name="chauffeur_id" class="form-select">
                    <option value="">— Aucun —</option>
                    @foreach($chauffeurs as $c)
                    <option value="{{ $c->id }}" @selected(old('chauffeur_id',$vehicule->chauffeur_id)==$c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Affectation / Service</label>
                <input type="text" name="affectation" value="{{ old('affectation', $vehicule->affectation) }}" class="form-input">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Expiration assurance</label>
                <input type="date" name="date_expiration_assurance" value="{{ old('date_expiration_assurance', $vehicule->date_expiration_assurance?->format('Y-m-d')) }}" class="form-input">
            </div>
            <div>
                <label class="form-label">Expiration visite technique</label>
                <input type="date" name="date_expiration_visite_technique" value="{{ old('date_expiration_visite_technique', $vehicule->date_expiration_visite_technique?->format('Y-m-d')) }}" class="form-input">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Prochain entretien (date)</label>
                <input type="date" name="prochain_entretien_date" value="{{ old('prochain_entretien_date', $vehicule->prochain_entretien_date?->format('Y-m-d')) }}" class="form-input">
            </div>
            <div>
                <label class="form-label">Prochain entretien (km)</label>
                <input type="number" name="prochain_entretien_km" value="{{ old('prochain_entretien_km', $vehicule->prochain_entretien_km) }}" class="form-input" min="0">
            </div>
        </div>
        <div>
            <label class="form-label">Notes</label>
            <textarea name="notes" rows="2" class="form-input">{{ old('notes', $vehicule->notes) }}</textarea>
        </div>
    </div>

    <div class="flex gap-3">
        <button type="submit" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ $vehicule->exists ? 'Mettre à jour' : 'Enregistrer' }}
        </button>
        <a href="{{ route('vehicules.index') }}" class="btn-secondary">Annuler</a>
    </div>
</form>
</div>
@endsection
