<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            $table->string('immatriculation')->unique();
            $table->string('marque');
            $table->string('modele');
            $table->year('annee');
            $table->enum('type_carburant', ['essence', 'diesel', 'hybride', 'electrique'])->default('diesel');
            $table->string('couleur')->nullable();
            $table->string('numero_chassis')->nullable();
            $table->integer('kilometrage_actuel')->default(0);
            $table->enum('statut', ['disponible', 'en_mission', 'en_maintenance', 'hors_service'])->default('disponible');
            $table->string('affectation')->nullable();
            $table->foreignId('chauffeur_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('date_acquisition')->nullable();
            $table->decimal('valeur_acquisition', 14, 2)->nullable();
            $table->date('date_expiration_assurance')->nullable();
            $table->date('date_expiration_visite_technique')->nullable();
            $table->date('prochain_entretien_date')->nullable();
            $table->integer('prochain_entretien_km')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicules');
    }
};
