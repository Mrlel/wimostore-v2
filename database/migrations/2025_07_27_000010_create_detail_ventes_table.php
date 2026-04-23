<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('details_vente', function (Blueprint $table) {
    $table->id();
    $table->foreignId('mouvement_id')->constrained('mouvements')->onDelete('cascade');
    $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');
    $table->integer('quantite');
    $table->decimal('prix_unitaire', 10, 2);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_ventes');
    }
};
