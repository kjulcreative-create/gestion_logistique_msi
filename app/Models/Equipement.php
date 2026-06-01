<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipement extends Model
{
    protected $fillable = [
        'code', 'designation', 'marque', 'modele', 'numero_serie',
        'date_acquisition', 'valeur_acquisition', 'fournisseur_acquisition',
        'statut', 'localisation', 'affectation', 'responsable_id',
        'date_prochain_entretien', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'date_acquisition'       => 'date',
            'date_prochain_entretien'=> 'date',
            'valeur_acquisition'     => 'decimal:2',
        ];
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function maintenances()
    {
        return $this->hasMany(MaintenanceEquipement::class);
    }

    public function getStatutLibelleAttribute(): string
    {
        return match($this->statut) {
            'en_service'     => 'En service',
            'en_maintenance' => 'En maintenance',
            'hors_service'   => 'Hors service',
            'reforme'        => 'Réformé',
            default          => $this->statut,
        };
    }

    public function getStatutClassAttribute(): string
    {
        return match($this->statut) {
            'en_service'     => 'bg-green-100 text-green-700',
            'en_maintenance' => 'bg-yellow-100 text-yellow-700',
            'hors_service'   => 'bg-red-100 text-red-700',
            'reforme'        => 'bg-gray-100 text-gray-700',
            default          => 'bg-gray-100 text-gray-700',
        };
    }
}
