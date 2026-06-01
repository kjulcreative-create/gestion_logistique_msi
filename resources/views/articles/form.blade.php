@extends('layouts.admin')
@section('title', $article->exists ? 'Modifier article' : 'Nouvel article')
@section('page-title', $article->exists ? 'Modifier article' : 'Nouvel article')

@section('content')
<div class="max-w-2xl">
<form method="POST" action="{{ $article->exists ? route('articles.update', $article) : route('articles.store') }}">
    @csrf
    @if($article->exists) @method('PUT') @endif

    <div class="card p-6 space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Code <span class="text-red-500">*</span></label>
                <input type="text" name="code" value="{{ old('code', $article->code) }}" class="form-input" required>
                @error('code')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label">Statut</label>
                <select name="statut" class="form-select">
                    <option value="actif" @selected(old('statut', $article->statut ?? 'actif') === 'actif')>Actif</option>
                    <option value="inactif" @selected(old('statut', $article->statut) === 'inactif')>Inactif</option>
                </select>
            </div>
        </div>

        <div>
            <label class="form-label">Désignation <span class="text-red-500">*</span></label>
            <input type="text" name="designation" value="{{ old('designation', $article->designation) }}" class="form-input" required>
            @error('designation')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="form-label">Description</label>
            <textarea name="description" rows="2" class="form-input">{{ old('description', $article->description) }}</textarea>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="form-label">Unité <span class="text-red-500">*</span></label>
                <input type="text" name="unite" value="{{ old('unite', $article->unite ?? 'pièce') }}" class="form-input" required placeholder="pièce, boîte, litre…">
            </div>
            <div>
                <label class="form-label">Quantité en stock <span class="text-red-500">*</span></label>
                <input type="number" name="quantite_stock" value="{{ old('quantite_stock', $article->quantite_stock ?? 0) }}" class="form-input" step="0.01" min="0" required>
            </div>
            <div>
                <label class="form-label">Seuil d'alerte <span class="text-red-500">*</span></label>
                <input type="number" name="seuil_alerte" value="{{ old('seuil_alerte', $article->seuil_alerte ?? 5) }}" class="form-input" step="0.01" min="0" required>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Prix unitaire (FCFA)</label>
                <input type="number" name="prix_unitaire" value="{{ old('prix_unitaire', $article->prix_unitaire) }}" class="form-input" step="1" min="0">
            </div>
            <div>
                <label class="form-label">Catégorie</label>
                <select name="categorie_id" class="form-select">
                    <option value="">Sans catégorie</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('categorie_id', $article->categorie_id) == $cat->id)>{{ $cat->nom }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="form-label">Localisation (magasin / étagère)</label>
            <input type="text" name="localisation" value="{{ old('localisation', $article->localisation) }}" class="form-input" placeholder="Magasin A - Étagère 3">
        </div>
    </div>

    <div class="flex gap-3 mt-4">
        <button type="submit" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ $article->exists ? 'Mettre à jour' : 'Enregistrer' }}
        </button>
        <a href="{{ route('articles.index') }}" class="btn-secondary">Annuler</a>
    </div>
</form>
</div>
@endsection
