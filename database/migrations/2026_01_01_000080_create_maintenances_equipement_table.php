<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenances_equipement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipement_id')->constrained('equipements')->cascadeOnDelete();
            $table->enum('type_maintenance', ['preventive', 'corrective', 'revision']);
            $table->date('date_maintenance');
            $table->decimal('cout', 12, 2)->nullable();
            $table->string('prestataire')->nullable();
            $table->text('description');
            $table->text('pieces_changees')->nullable();
            $table->date('prochain_entretien')->nullable();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenances_equipement');
    }
};
