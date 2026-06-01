@extends('layouts.admin')
@section('title', $equipement->exists ? 'Modifier équipement' : 'Nouvel équipement')
@section('page-title', $equipement->exists ? 'Modifier équipement' : 'Nouvel équipement')

@section('content')
<div class="max-w-2xl">
<form method="POST" action="{{ $equipement->exists ? route('equipements.update', $equipement) : route('equipements.store') }}">
    @csrf
    @if($equipement->exists) @method('PUT') @endif

    <div class="card p-6 space-y-4 mb-4">
        <h3 class="font-semibold text-gray-900 border-b pb-3">Identification</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Code <span class="text-red-500">*</span></label>
                <input type="text" name="code" value="{{ old('code', $equipement->code) }}" class="form-input" required>
                @error('code')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label">Statut <span class="text-red-500">*</span></label>
                <select name="statut" class="form-select" required>
                    <option value="en_service" @selected(old('statut',$equipement->statut??'en_service')==='en_service')>En service</option>
                    <option value="en_maintenance" @selected(old('statut',$equipement->statut)==='en_maintenance')>En maintenance</option>
                    <option value="hors_service" @selected(old('statut',$equipement->statut)==='hors_service')>Hors service</option>
                    <option value="reforme" @selected(old('statut',$equipement->statut)==='reforme')>Réformé</option>
                </select>
            </div>
        </div>
        <div>
            <label class="form-label">Désignation <span class="text-red-500">*</span></label>
            <input type="text" name="designation" value="{{ old('designation', $equipement->designation) }}" class="form-input" required>
        </div>
        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="form-label">Marque</label>
                <input type="text" name="marque" value="{{ old('marque', $equipement->marque) }}" class="form-input">
            </div>
            <div>
                <label class="form-label">Modèle</label>
                <input type="text" name="modele" value="{{ old('modele', $equipement->modele) }}" class="form-input">
            </div>
            <div>
                <label class="form-label">Numéro de série</label>
                <input type="text" name="numero_serie" value="{{ old('numero_serie', $equipement->numero_serie) }}" class="form-input">
            </div>
        </div>
    </div>

    <div class="card p-6 space-y-4 mb-4">
        <h3 class="font-semibold text-gray-900 border-b pb-3">Acquisition & Affectation</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Date d'acquisition</label>
                <input type="date" name="date_acquisition" value="{{ old('date_acquisition', $equipement->date_acquisition?->format('Y-m-d')) }}" class="form-input">
            </div>
            <div>
                <label class="form-label">Valeur d'acquisition (FCFA)</label>
                <input type="number" name="valeur_acquisition" value="{{ old('valeur_acquisition', $equipement->valeur_acquisition) }}" class="form-input" step="1" min="0">
            </div>
        </div>
        <div>
            <label class="form-label">Fournisseur d'acquisition</label>
            <input type="text" name="fournisseur_acquisition" value="{{ old('fournisseur_acquisition', $equipement->fournisseur_acquisition) }}" class="form-input">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Localisation</label>
                <input type="text" name="localisation" value="{{ old('localisation', $equipement->localisation) }}" class="form-input" placeholder="Bureau, salle, site…">
            </div>
            <div>
                <label class="form-label">Affectation (service)</label>
                <input type="text" name="affectation" value="{{ old('affectation', $equipement->affectation) }}" class="form-input">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Responsable</label>
                <select name="responsable_id" class="form-select">
                    <option value="">— Aucun —</option>
                    @foreach($responsables as $user)
                    <option value="{{ $user->id }}" @selected(old('responsable_id',$equipement->responsable_id)==$user->id)>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Prochain entretien</label>
                <input type="date" name="date_prochain_entretien" value="{{ old('date_prochain_entretien', $equipement->date_prochain_entretien?->format('Y-m-d')) }}" class="form-input">
            </div>
        </div>
        <div>
            <label class="form-label">Notes</label>
            <textarea name="notes" rows="2" class="form-input">{{ old('notes', $equipement->notes) }}</textarea>
        </div>
    </div>

    <div class="flex gap-3">
        <button type="submit" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ $equipement->exists ? 'Mettre à jour' : 'Enregistrer' }}
        </button>
        <a href="{{ route('equipements.index') }}" class="btn-secondary">Annuler</a>
    </div>
</form>
</div>
@endsection
