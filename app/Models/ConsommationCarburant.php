<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsommationCarburant extends Model
{
    protected $table = 'consommations_carburant';

    protected $fillable = [
        'vehicule_id', 'mission_id', 'user_id', 'date',
        'quantite_litres', 'prix_litre', 'montant_total',
        'station', 'km_compteur', 'notes',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $c) {
            $c->montant_total = $c->quantite_litres * $c->prix_litre;
        });
    }

    protected function casts(): array
    {
        return [
            'date'           => 'date',
            'quantite_litres'=> 'decimal:2',
            'prix_litre'     => 'decimal:2',
            'montant_total'  => 'decimal:2',
        ];
    }

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }

    public function mission()
    {
        return $this->belongsTo(MissionVehicule::class, 'mission_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
