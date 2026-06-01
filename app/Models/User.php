<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'telephone', 'poste', 'actif',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'actif' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function getRoleLibelleAttribute(): string
    {
        return match($this->role) {
            'admin'                   => 'Administrateur',
            'gestionnaire_achats'     => 'Gestionnaire Achats',
            'gestionnaire_stocks'     => 'Gestionnaire Stocks',
            'gestionnaire_equipements'=> 'Gestionnaire Équipements',
            'gestionnaire_flotte'     => 'Gestionnaire Flotte',
            default                   => 'Utilisateur',
        };
    }

    public function commandesAchats()
    {
        return $this->hasMany(CommandeAchat::class);
    }

    public function mouvementsStock()
    {
        return $this->hasMany(MouvementStock::class);
    }

    public function equipementsResponsable()
    {
        return $this->hasMany(Equipement::class, 'responsable_id');
    }

    public function vehiculesChauffeur()
    {
        return $this->hasMany(Vehicule::class, 'chauffeur_id');
    }

    public function missionsCommeChauffeur()
    {
        return $this->hasMany(MissionVehicule::class, 'chauffeur_id');
    }
}
