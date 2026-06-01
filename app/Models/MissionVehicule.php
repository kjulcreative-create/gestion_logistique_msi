<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissionVehicule extends Model
{
    protected $table = 'missions_vehicule';

    protected $fillable = [
        'reference', 'vehicule_id', 'chauffeur_id', 'demandeur_id',
        'destination', 'objet', 'date_depart', 'heure_depart',
        'date_retour_prevue', 'date_retour_reelle',
        'km_depart', 'km_retour', 'statut', 'observations',
    ];

    protected function casts(): array
    {
        return [
            'date_depart'        => 'date',
            'date_retour_prevue' => 'date',
            'date_retour_reelle' => 'date',
        ];
    }

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }

    public function chauffeur()
    {
        return $this->belongsTo(User::class, 'chauffeur_id');
    }

    public function demandeur()
    {
        return $this->belongsTo(User::class, 'demandeur_id');
    }

    public function consommations()
    {
        return $this->hasMany(ConsommationCarburant::class, 'mission_id');
    }

    public function getStatutLibelleAttribute(): string
    {
        return match($this->statut) {
            'planifiee' => 'Planifiée',
            'en_cours'  => 'En cours',
            'terminee'  => 'Terminée',
            'annulee'   => 'Annulée',
            default     => $this->statut,
        };
    }

    public function getStatutClassAttribute(): string
    {
        return match($this->statut) {
            'planifiee' => 'bg-blue-100 text-blue-700',
            'en_cours'  => 'bg-yellow-100 text-yellow-700',
            'terminee'  => 'bg-green-100 text-green-700',
            'annulee'   => 'bg-red-100 text-red-700',
            default     => 'bg-gray-100 text-gray-700',
        };
    }

    public function getKmParcourus(): ?int
    {
        if ($this->km_depart && $this->km_retour) {
            return $this->km_retour - $this->km_depart;
        }
        return null;
    }
}
