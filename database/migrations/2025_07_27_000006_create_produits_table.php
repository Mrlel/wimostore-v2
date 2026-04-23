<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cabine_id')->constrained('cabines')->onDelete('cascade');
            $table->foreignId('categorie_id')->constrained()->onDelete('cascade');
            $table->foreignId('fournisseur_id')->nullable()->constrained('fournisseurs')->onDelete('set null');
            $table->string('code')->unique();
            $table->string('nom');
            $table->string('marque')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->decimal('prix_achat', 10, 2);
            $table->decimal('prix_vente', 10, 2);
            $table->integer('seuil_alerte')->default(5); 
            $table->integer('quantite_stock')->default(0);
            $table->boolean('actif')->default(true);
            $table->boolean('publier')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
