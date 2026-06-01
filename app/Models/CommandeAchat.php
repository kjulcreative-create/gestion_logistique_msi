<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommandeAchat extends Model
{
    protected $table = 'commandes_achats';

    protected $fillable = [
        'reference', 'fournisseur_id', 'user_id', 'date_commande',
        'date_livraison_prevue', 'date_livraison_reelle', 'statut',
        'montant_total', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'date_commande'         => 'date',
            'date_livraison_prevue' => 'date',
            'date_livraison_reelle' => 'date',
            'montant_total'         => 'decimal:2',
        ];
    }

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lignes()
    {
        return $this->hasMany(LigneCommande::class, 'commande_id');
    }

    public function mouvements()
    {
        return $this->hasMany(MouvementStock::class, 'commande_id');
    }

    public function getStatutLibelleAttribute(): string
    {
        return match($this->statut) {
            'brouillon'  => 'Brouillon',
            'validee'    => 'Validée',
            'en_cours'   => 'En cours',
            'livree'     => 'Livrée',
            'annulee'    => 'Annulée',
            default      => $this->statut,
        };
    }

    public function getStatutClassAttribute(): string
    {
        return match($this->statut) {
            'brouillon'  => 'bg-gray-100 text-gray-700',
            'validee'    => 'bg-blue-100 text-blue-700',
            'en_cours'   => 'bg-yellow-100 text-yellow-700',
            'livree'     => 'bg-green-100 text-green-700',
            'annulee'    => 'bg-red-100 text-red-700',
            default      => 'bg-gray-100 text-gray-700',
        };
    }
}
