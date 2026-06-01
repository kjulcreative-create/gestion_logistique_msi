<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneCommande extends Model
{
    protected $table = 'lignes_commande';

    protected $fillable = [
        'commande_id', 'article_id', 'quantite', 'quantite_recue',
        'prix_unitaire', 'montant_ligne',
    ];

    protected function casts(): array
    {
        return [
            'quantite'      => 'decimal:2',
            'quantite_recue'=> 'decimal:2',
            'prix_unitaire' => 'decimal:2',
            'montant_ligne' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (self $ligne) {
            $ligne->montant_ligne = $ligne->quantite * $ligne->prix_unitaire;
        });
    }

    public function commande()
    {
        return $this->belongsTo(CommandeAchat::class, 'commande_id');
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
