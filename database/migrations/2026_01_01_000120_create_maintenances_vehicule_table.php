<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenances_vehicule', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicule_id')->constrained('vehicules')->restrictOnDelete();
            $table->enum('type_maintenance', ['vidange', 'revision', 'reparation', 'pneus', 'freins', 'autre'])->default('revision');
            $table->date('date_maintenance');
            $table->integer('km_effectue')->nullable();
            $table->decimal('cout', 12, 2)->nullable();
            $table->string('prestataire')->nullable();
            $table->text('description');
            $table->text('pieces_changees')->nullable();
            $table->date('prochain_entretien_date')->nullable();
            $table->integer('prochain_entretien_km')->nullable();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenances_vehicule');
    }
};
