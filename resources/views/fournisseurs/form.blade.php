@extends('layouts.admin')
@section('title', $fournisseur->exists ? 'Modifier fournisseur' : 'Nouveau fournisseur')
@section('page-title', $fournisseur->exists ? 'Modifier fournisseur' : 'Nouveau fournisseur')
@section('breadcrumb')
    <span class="mx-1">/</span><a href="{{ route('fournisseurs.index') }}" class="hover:text-emerald-600">Fournisseurs</a>
    <span class="mx-1">/</span> {{ $fournisseur->exists ? $fournisseur->nom : 'Nouveau' }}
@endsection

@section('content')
<div class="max-w-2xl">
<form method="POST" action="{{ $fournisseur->exists ? route('fournisseurs.update', $fournisseur) : route('fournisseurs.store') }}">
    @csrf
    @if($fournisseur->exists) @method('PUT') @endif

    <div class="card p-6 space-y-4">
        <h2 class="font-semibold text-gray-900 text-lg border-b border-gray-100 pb-3">Informations générales</h2>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Code fournisseur <span class="text-red-500">*</span></label>
                <input type="text" name="code" value="{{ old('code', $fournisseur->code) }}" class="form-input" required placeholder="F001">
                @error('code')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label">Statut <span class="text-red-500">*</span></label>
                <select name="statut" class="form-select" required>
                    <option value="actif" @selected(old('statut', $fournisseur->statut) === 'actif')>Actif</option>
                    <option value="inactif" @selected(old('statut', $fournisseur->statut) === 'inactif')>Inactif</option>
                </select>
            </div>
        </div>

        <div>
            <label class="form-label">Nom / Raison sociale <span class="text-red-500">*</span></label>
            <input type="text" name="nom" value="{{ old('nom', $fournisseur->nom) }}" class="form-input" required>
            @error('nom')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Personne contact</label>
                <input type="text" name="contact" value="{{ old('contact', $fournisseur->contact) }}" class="form-input">
            </div>
            <div>
                <label class="form-label">Téléphone</label>
                <input type="text" name="telephone" value="{{ old('telephone', $fournisseur->telephone) }}" class="form-input" placeholder="+226 XX XX XX XX">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $fournisseur->email) }}" class="form-input">
            </div>
            <div>
                <label class="form-label">Type de fourniture</label>
                <input type="text" name="type_fourniture" value="{{ old('type_fourniture', $fournisseur->type_fourniture) }}" class="form-input" placeholder="Ex: Matériel informatique">
            </div>
        </div>

        <div>
            <label class="form-label">Adresse</label>
            <textarea name="adresse" rows="2" class="form-input">{{ old('adresse', $fournisseur->adresse) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Ville</label>
                <input type="text" name="ville" value="{{ old('ville', $fournisseur->ville) }}" class="form-input">
            </div>
            <div>
                <label class="form-label">Pays</label>
                <input type="text" name="pays" value="{{ old('pays', $fournisseur->pays ?? 'Burkina Faso') }}" class="form-input">
            </div>
        </div>
    </div>

    <div class="flex gap-3 mt-4">
        <button type="submit" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ $fournisseur->exists ? 'Mettre à jour' : 'Enregistrer' }}
        </button>
        <a href="{{ route('fournisseurs.index') }}" class="btn-secondary">Annuler</a>
    </div>
</form>
</div>
@endsection
