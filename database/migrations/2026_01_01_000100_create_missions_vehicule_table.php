<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('missions_vehicule', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->foreignId('vehicule_id')->constrained('vehicules')->restrictOnDelete();
            $table->foreignId('chauffeur_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('demandeur_id')->constrained('users')->restrictOnDelete();
            $table->string('destination');
            $table->text('objet');
            $table->date('date_depart');
            $table->time('heure_depart')->nullable();
            $table->date('date_retour_prevue');
            $table->date('date_retour_reelle')->nullable();
            $table->integer('km_depart')->nullable();
            $table->integer('km_retour')->nullable();
            $table->enum('statut', ['planifiee', 'en_cours', 'terminee', 'annulee'])->default('planifiee');
            $table->text('observations')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('missions_vehicule');
    }
};
