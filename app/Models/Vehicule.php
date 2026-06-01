<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    protected $fillable = [
        'immatriculation', 'marque', 'modele', 'annee', 'type_carburant',
        'couleur', 'numero_chassis', 'kilometrage_actuel', 'statut',
        'affectation', 'chauffeur_id', 'date_acquisition', 'valeur_acquisition',
        'date_expiration_assurance', 'date_expiration_visite_technique',
        'prochain_entretien_date', 'prochain_entretien_km', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'date_acquisition'                 => 'date',
            'date_expiration_assurance'        => 'date',
            'date_expiration_visite_technique' => 'date',
            'prochain_entretien_date'          => 'date',
            'valeur_acquisition'               => 'decimal:2',
        ];
    }

    public function chauffeur()
    {
        return $this->belongsTo(User::class, 'chauffeur_id');
    }

    public function missions()
    {
        return $this->hasMany(MissionVehicule::class);
    }

    public function consommations()
    {
        return $this->hasMany(ConsommationCarburant::class);
    }

    public function maintenances()
    {
        return $this->hasMany(MaintenanceVehicule::class);
    }

    public function getStatutLibelleAttribute(): string
    {
        return match($this->statut) {
            'disponible'     => 'Disponible',
            'en_mission'     => 'En mission',
            'en_maintenance' => 'En maintenance',
            'hors_service'   => 'Hors service',
            default          => $this->statut,
        };
    }

    public function getStatutClassAttribute(): string
    {
        return match($this->statut) {
            'disponible'     => 'bg-green-100 text-green-700',
            'en_mission'     => 'bg-blue-100 text-blue-700',
            'en_maintenance' => 'bg-yellow-100 text-yellow-700',
            'hors_service'   => 'bg-red-100 text-red-700',
            default          => 'bg-gray-100 text-gray-700',
        };
    }

    public function assuranceExpiree(): bool
    {
        return $this->date_expiration_assurance && $this->date_expiration_assurance->isPast();
    }
}
