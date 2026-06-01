@extends('layouts.admin')
@section('title', $commande->exists ? 'Modifier commande' : 'Nouvelle commande')
@section('page-title', $commande->exists ? 'Modifier commande' : 'Nouvelle commande')

@section('content')
<form method="POST" action="{{ $commande->exists ? route('commandes.update', $commande) : route('commandes.store') }}">
    @csrf
    @if($commande->exists) @method('PUT') @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-4">
            <div class="card p-6 space-y-4">
                <h3 class="font-semibold text-gray-900">Informations de la commande</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Référence <span class="text-red-500">*</span></label>
                        <input type="text" name="reference" value="{{ old('reference', $commande->reference ?? 'BC-'.date('Y').'-') }}" class="form-input" required>
                        @error('reference')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">Statut</label>
                        <select name="statut" class="form-select">
                            @foreach(['brouillon'=>'Brouillon','validee'=>'Validée','en_cours'=>'En cours','livree'=>'Livrée','annulee'=>'Annulée'] as $val=>$lib)
                            <option value="{{ $val }}" @selected(old('statut',$commande->statut??'brouillon')===$val)>{{ $lib }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="form-label">Fournisseur <span class="text-red-500">*</span></label>
                    <select name="fournisseur_id" class="form-select" required>
                        <option value="">— Sélectionner —</option>
                        @foreach($fournisseurs as $f)
                        <option value="{{ $f->id }}" @selected(old('fournisseur_id',$commande->fournisseur_id)==$f->id)>{{ $f->nom }}</option>
                        @endforeach
                    </select>
                    @error('fournisseur_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Date commande <span class="text-red-500">*</span></label>
                        <input type="date" name="date_commande" value="{{ old('date_commande', $commande->date_commande?->format('Y-m-d') ?? date('Y-m-d')) }}" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label">Livraison prévue</label>
                        <input type="date" name="date_livraison_prevue" value="{{ old('date_livraison_prevue', $commande->date_livraison_prevue?->format('Y-m-d')) }}" class="form-input">
                    </div>
                </div>
                <div>
                    <label class="form-label">Notes</label>
                    <textarea name="notes" rows="2" class="form-input">{{ old('notes', $commande->notes) }}</textarea>
                </div>
            </div>

            @if(!$commande->exists)
            <div class="card p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900">Lignes de commande</h3>
                    <button type="button" onclick="ajouterLigne()" class="btn-secondary text-xs">+ Ajouter une ligne</button>
                </div>
                <div id="lignes" class="space-y-3">
                    <div class="ligne-commande grid grid-cols-12 gap-2 items-end">
                        <div class="col-span-6">
                            <label class="form-label text-xs">Article</label>
                            <select name="lignes[0][article_id]" class="form-select text-sm" required>
                                <option value="">— Article —</option>
                                @foreach($articles as $art)
                                <option value="{{ $art->id }}">{{ $art->designation }} ({{ $art->unite }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label class="form-label text-xs">Quantité</label>
                            <input type="number" name="lignes[0][quantite]" class="form-input text-sm" step="0.01" min="0.01" required placeholder="0">
                        </div>
                        <div class="col-span-3">
                            <label class="form-label text-xs">Prix unitaire (FCFA)</label>
                            <input type="number" name="lignes[0][prix_unitaire]" class="form-input text-sm" step="1" min="0" required placeholder="0">
                        </div>
                        <div class="col-span-1">
                            <button type="button" onclick="this.closest('.ligne-commande').remove()" class="text-red-400 hover:text-red-600 mt-1">✕</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="space-y-4">
            <div class="card p-5">
                <button type="submit" class="btn-primary w-full justify-center mb-2">
                    {{ $commande->exists ? 'Mettre à jour' : 'Créer la commande' }}
                </button>
                <a href="{{ route('commandes.index') }}" class="btn-secondary w-full justify-center">Annuler</a>
            </div>
        </div>
    </div>
</form>

@if(!$commande->exists)
<script>
let idx = 1;
const articles = @json($articles->map(fn($a) => ['id'=>$a->id,'designation'=>$a->designation,'unite'=>$a->unite]));

function ajouterLigne() {
    const select = articles.map(a => `<option value="${a.id}">${a.designation} (${a.unite})</option>`).join('');
    const html = `<div class="ligne-commande grid grid-cols-12 gap-2 items-end">
        <div class="col-span-6"><select name="lignes[${idx}][article_id]" class="form-select text-sm" required><option value="">— Article —</option>${select}</select></div>
        <div class="col-span-2"><input type="number" name="lignes[${idx}][quantite]" class="form-input text-sm" step="0.01" min="0.01" required placeholder="0"></div>
        <div class="col-span-3"><input type="number" name="lignes[${idx}][prix_unitaire]" class="form-input text-sm" step="1" min="0" required placeholder="0"></div>
        <div class="col-span-1"><button type="button" onclick="this.closest('.ligne-commande').remove()" class="text-red-400 hover:text-red-600 mt-1">✕</button></div>
    </div>`;
    document.getElementById('lignes').insertAdjacentHTML('beforeend', html);
    idx++;
}
</script>
@endif
@endsection
