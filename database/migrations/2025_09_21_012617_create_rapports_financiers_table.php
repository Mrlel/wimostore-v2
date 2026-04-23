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
        Schema::create('rapports_financiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cabine_id')->constrained('cabines')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Période du rapport
            $table->date('date_debut');
            $table->date('date_fin');
            $table->enum('type_rapport', ['quotidien', 'hebdomadaire', 'mensuel', 'annuel', 'personnalise']);
            
            // Chiffre d'affaires (Gains)
            $table->decimal('chiffre_affaires_total', 12, 2)->default(0);
            $table->decimal('ventes_especes', 12, 2)->default(0);
            $table->decimal('ventes_carte', 12, 2)->default(0);
            $table->decimal('ventes_mobile', 12, 2)->default(0);
            $table->decimal('ventes_virement', 12, 2)->default(0);
            $table->decimal('ventes_autre', 12, 2)->default(0);
            
            // Coûts d'achat (Pertes)
            $table->decimal('cout_achats_total', 12, 2)->default(0);
            $table->decimal('cout_stock_initial', 12, 2)->default(0);
            $table->decimal('cout_stock_final', 12, 2)->default(0);
            
            // Coûts fixes (Pertes)
            $table->decimal('loyer', 10, 2)->default(0);
            $table->decimal('electricite', 10, 2)->default(0);
            $table->decimal('eau', 10, 2)->default(0);
            $table->decimal('internet', 10, 2)->default(0);
            $table->decimal('maintenance', 10, 2)->default(0);
            $table->decimal('autres_charges', 10, 2)->default(0);
            
            // Calculs automatiques
            $table->decimal('marge_brute', 12, 2)->default(0); // CA - Coût achats
            $table->decimal('marge_nette', 12, 2)->default(0); // Marge brute - Coûts fixes
            $table->decimal('taux_marge_brute', 5, 2)->default(0); // % marge brute
            $table->decimal('taux_marge_nette', 5, 2)->default(0); // % marge nette
            
            // Métriques de performance
            $table->integer('nombre_ventes')->default(0);
            $table->integer('nombre_produits_vendus')->default(0);
            $table->decimal('panier_moyen', 10, 2)->default(0);
            $table->decimal('produit_moyen_vendu', 10, 2)->default(0);
            
            // Statut et validation
            $table->boolean('est_valide')->default(false);
            $table->text('remarques')->nullable();
            $table->timestamp('date_validation')->nullable();
            $table->foreignId('valide_par')->nullable()->constrained('users');
            
            $table->timestamps();
            
            // Index pour optimiser les requêtes
            $table->index(['cabine_id', 'date_debut', 'date_fin']);
            $table->index(['type_rapport', 'date_debut']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapports_financiers');
    }
};
