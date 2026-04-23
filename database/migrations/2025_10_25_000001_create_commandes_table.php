<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_commande')->unique();
            $table->string('nom_client');
            $table->string('telephone_client');
            $table->string('email_client')->nullable();
            $table->text('adresse_livraison')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('montant_total', 10, 2);
            $table->enum('statut', ['en_attente', 'confirmee', 'en_preparation', 'expediee', 'livree', 'annulee'])
                  ->default('en_attente');
            $table->enum('mode_paiement', ['a_la_livraison', 'mobile_money', 'autre'])->default('a_la_livraison');
            $table->foreignId('cabine_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('ligne_commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained('commandes')->onDelete('cascade');
            $table->foreignId('produit_id')->constrained()->onDelete('cascade');
            $table->integer('quantite');
            $table->decimal('prix_unitaire', 10, 2);
            $table->decimal('sous_total', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ligne_commandes');
        Schema::dropIfExists('commandes');
    }
};
