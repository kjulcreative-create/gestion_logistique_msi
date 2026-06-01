<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipements', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('designation');
            $table->string('marque')->nullable();
            $table->string('modele')->nullable();
            $table->string('numero_serie')->nullable();
            $table->date('date_acquisition')->nullable();
            $table->decimal('valeur_acquisition', 14, 2)->nullable();
            $table->string('fournisseur_acquisition')->nullable();
            $table->enum('statut', ['en_service', 'en_maintenance', 'hors_service', 'reforme'])->default('en_service');
            $table->string('localisation')->nullable();
            $table->string('affectation')->nullable();
            $table->foreignId('responsable_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('date_prochain_entretien')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipements');
    }
};
