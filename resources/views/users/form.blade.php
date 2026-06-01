@extends('layouts.admin')
@section('title', $user->exists ? 'Modifier utilisateur' : 'Nouvel utilisateur')
@section('page-title', $user->exists ? 'Modifier utilisateur' : 'Nouvel utilisateur')

@section('content')
<div class="max-w-xl">
<form method="POST" action="{{ $user->exists ? route('users.update', $user) : route('users.store') }}">
    @csrf
    @if($user->exists) @method('PUT') @endif

    <div class="card p-6 space-y-4">
        <div>
            <label class="form-label">Nom complet <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input" required>
            @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Email <span class="text-red-500">*</span></label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input" required>
            @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Mot de passe {{ $user->exists ? '(laisser vide = inchangé)' : '' }} <span class="text-red-500">{{ !$user->exists ? '*' : '' }}</span></label>
            <input type="password" name="password" class="form-input" {{ !$user->exists ? 'required' : '' }} autocomplete="new-password">
            @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>
        @if(!$user->exists)
        <div>
            <label class="form-label">Confirmer le mot de passe <span class="text-red-500">*</span></label>
            <input type="password" name="password_confirmation" class="form-input" required>
        </div>
        @endif
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Rôle <span class="text-red-500">*</span></label>
                <select name="role" class="form-select" required>
                    <option value="utilisateur" @selected(old('role',$user->role??'utilisateur')==='utilisateur')>Utilisateur</option>
                    <option value="gestionnaire_achats" @selected(old('role',$user->role)==='gestionnaire_achats')>Gestionnaire Achats</option>
                    <option value="gestionnaire_stocks" @selected(old('role',$user->role)==='gestionnaire_stocks')>Gestionnaire Stocks</option>
                    <option value="gestionnaire_equipements" @selected(old('role',$user->role)==='gestionnaire_equipements')>Gestionnaire Équipements</option>
                    <option value="gestionnaire_flotte" @selected(old('role',$user->role)==='gestionnaire_flotte')>Gestionnaire Flotte</option>
                    <option value="admin" @selected(old('role',$user->role)==='admin')>Administrateur</option>
                </select>
            </div>
            <div>
                <label class="form-label">Statut</label>
                <select name="actif" class="form-select">
                    <option value="1" @selected(old('actif', $user->actif ?? 1) == 1)>Actif</option>
                    <option value="0" @selected(old('actif', $user->actif) == 0)>Inactif</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Téléphone</label>
                <input type="text" name="telephone" value="{{ old('telephone', $user->telephone) }}" class="form-input" placeholder="+226 XX XX XX XX">
            </div>
            <div>
                <label class="form-label">Poste / Fonction</label>
                <input type="text" name="poste" value="{{ old('poste', $user->poste) }}" class="form-input">
            </div>
        </div>
    </div>

    <div class="flex gap-3 mt-4">
        <button type="submit" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ $user->exists ? 'Mettre à jour' : 'Créer l\'utilisateur' }}
        </button>
        <a href="{{ route('users.index') }}" class="btn-secondary">Annuler</a>
    </div>
</form>
</div>
@endsection
