<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consommations_carburant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicule_id')->constrained('vehicules')->restrictOnDelete();
            $table->foreignId('mission_id')->nullable()->constrained('missions_vehicule')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->date('date');
            $table->decimal('quantite_litres', 8, 2);
            $table->decimal('prix_litre', 8, 2);
            $table->decimal('montant_total', 10, 2)->default(0);
            $table->string('station')->nullable();
            $table->integer('km_compteur')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consommations_carburant');
    }
};
