<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'code', 'designation', 'description', 'unite', 'quantite_stock',
        'seuil_alerte', 'prix_unitaire', 'localisation', 'categorie_id', 'statut',
    ];

    protected function casts(): array
    {
        return [
            'quantite_stock' => 'decimal:2',
            'seuil_alerte'   => 'decimal:2',
            'prix_unitaire'  => 'decimal:2',
        ];
    }

    public function categorie()
    {
        return $this->belongsTo(CategorieArticle::class, 'categorie_id');
    }

    public function mouvements()
    {
        return $this->hasMany(MouvementStock::class);
    }

    public function lignesCommande()
    {
        return $this->hasMany(LigneCommande::class);
    }

    public function estEnAlerte(): bool
    {
        return $this->quantite_stock <= $this->seuil_alerte;
    }
}
