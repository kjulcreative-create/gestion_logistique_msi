<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    protected $table = 'fournisseurs';

    protected $fillable = [
        'code', 'nom', 'contact', 'telephone', 'email', 'adresse',
        'ville', 'pays', 'type_fourniture', 'statut',
    ];

    public function commandes()
    {
        return $this->hasMany(CommandeAchat::class);
    }
}
