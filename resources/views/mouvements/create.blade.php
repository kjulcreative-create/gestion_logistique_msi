@extends('layouts.admin')
@section('title', 'Nouveau mouvement de stock')
@section('page-title', 'Nouveau mouvement de stock')

@section('content')
<div class="max-w-xl">
<form method="POST" action="{{ route('mouvements.store') }}">
    @csrf
    <div class="card p-6 space-y-4">
        <div>
            <label class="form-label">Article <span class="text-red-500">*</span></label>
            <select name="article_id" class="form-select" required>
                <option value="">— Sélectionner un article —</option>
                @foreach($articles as $art)
                <option value="{{ $art->id }}" @selected(old('article_id', request('article_id')) == $art->id)>
                    {{ $art->designation }} (stock: {{ $art->quantite_stock }} {{ $art->unite }})
                </option>
                @endforeach
            </select>
            @error('article_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Type de mouvement <span class="text-red-500">*</span></label>
                <select name="type" class="form-select" required>
                    <option value="">— Choisir —</option>
                    <option value="entree" @selected(old('type')=='entree')>Entrée (réception)</option>
                    <option value="sortie" @selected(old('type')=='sortie')>Sortie (distribution)</option>
                    <option value="ajustement" @selected(old('type')=='ajustement')>Ajustement inventaire</option>
                </select>
                @error('type')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label">Quantité <span class="text-red-500">*</span></label>
                <input type="number" name="quantite" value="{{ old('quantite') }}" class="form-input" step="0.01" min="0.01" required>
                @error('quantite')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label class="form-label">Motif <span class="text-red-500">*</span></label>
            <input type="text" name="motif" value="{{ old('motif') }}" class="form-input" required placeholder="Distribution site Pissy, Réception commande…">
            @error('motif')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Référence document</label>
                <input type="text" name="reference_doc" value="{{ old('reference_doc') }}" class="form-input" placeholder="BC-2026-XXX, BS-2026-XXX">
            </div>
            <div>
                <label class="form-label">Date <span class="text-red-500">*</span></label>
                <input type="date" name="date_mouvement" value="{{ old('date_mouvement', date('Y-m-d')) }}" class="form-input" required>
                @error('date_mouvement')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
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
            Enregistrer le mouvement
        </button>
        <a href="{{ route('mouvements.index') }}" class="btn-secondary">Annuler</a>
    </div>
</form>
</div>
@endsection
