<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceVehicule extends Model
{
    protected $table = 'maintenances_vehicule';

    protected $fillable = [
        'vehicule_id', 'type_maintenance', 'date_maintenance', 'km_effectue',
        'cout', 'prestataire', 'description', 'pieces_changees',
        'prochain_entretien_date', 'prochain_entretien_km', 'user_id',
    ];

    protected function casts(): array
    {
        return [
            'date_maintenance'       => 'date',
            'prochain_entretien_date'=> 'date',
            'cout'                   => 'decimal:2',
        ];
    }

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTypeLibelleAttribute(): string
    {
        return match($this->type_maintenance) {
            'vidange'   => 'Vidange',
            'revision'  => 'Révision',
            'reparation'=> 'Réparation',
            'pneus'     => 'Pneus',
            'freins'    => 'Freins',
            default     => 'Autre',
        };
    }
}
