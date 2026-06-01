<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceEquipement extends Model
{
    protected $table = 'maintenances_equipement';

    protected $fillable = [
        'equipement_id', 'type_maintenance', 'date_maintenance', 'cout',
        'prestataire', 'description', 'pieces_changees', 'prochain_entretien', 'user_id',
    ];

    protected function casts(): array
    {
        return [
            'date_maintenance'  => 'date',
            'prochain_entretien'=> 'date',
            'cout'              => 'decimal:2',
        ];
    }

    public function equipement()
    {
        return $this->belongsTo(Equipement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
