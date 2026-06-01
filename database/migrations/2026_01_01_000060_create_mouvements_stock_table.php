<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mouvements_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles')->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->enum('type', ['entree', 'sortie', 'ajustement']);
            $table->decimal('quantite', 10, 2);
            $table->decimal('quantite_avant', 10, 2);
            $table->decimal('quantite_apres', 10, 2);
            $table->string('motif');
            $table->string('reference_doc')->nullable();
            $table->foreignId('commande_id')->nullable()->constrained('commandes_achats')->nullOnDelete();
            $table->date('date_mouvement');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mouvements_stock');
    }
};
