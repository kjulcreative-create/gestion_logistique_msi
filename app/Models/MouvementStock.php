<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MouvementStock extends Model
{
    protected $table = 'mouvements_stock';

    protected $fillable = [
        'article_id', 'user_id', 'type', 'quantite', 'quantite_avant',
        'quantite_apres', 'motif', 'reference_doc', 'commande_id',
        'date_mouvement', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'date_mouvement' => 'date',
            'quantite'       => 'decimal:2',
            'quantite_avant' => 'decimal:2',
            'quantite_apres' => 'decimal:2',
        ];
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commande()
    {
        return $this->belongsTo(CommandeAchat::class, 'commande_id');
    }

    public function getTypeLibelleAttribute(): string
    {
        return match($this->type) {
            'entree'     => 'Entrée',
            'sortie'     => 'Sortie',
            'ajustement' => 'Ajustement',
            default      => $this->type,
        };
    }

    public function getTypeClassAttribute(): string
    {
        return match($this->type) {
            'entree'     => 'bg-green-100 text-green-700',
            'sortie'     => 'bg-red-100 text-red-700',
            'ajustement' => 'bg-yellow-100 text-yellow-700',
            default      => 'bg-gray-100 text-gray-700',
        };
    }
}
