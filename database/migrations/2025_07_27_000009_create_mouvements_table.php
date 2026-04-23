<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('mouvements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['entree', 'sortie', 'ajustement']); // ✅ Ajouter ajustement
            $table->string('reference')->nullable(); // N° facture, bon de livraison
            $table->integer('quantite');
            $table->decimal('prix_unitaire', 10, 2)->nullable(); // ✅ Historique des prix
            $table->decimal('montant_total', 10, 2)->nullable();
            $table->timestamp('date_mouvement')->useCurrent();
            $table->enum('motif', ['achat', 'vente', 'inventaire', 'autre']); // ✅ Catégoriser
            $table->text('remarque')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('cabine_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mouvements');
    }
};
