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
    Schema::create('ventes', function (Blueprint $table) {
        $table->id();
        $table->string('numero_vente')->unique();
        $table->string('receipt_number')->nullable()->unique();
        $table->string('type_client')->default('divers'); // particulier, professionnel, divers
        $table->string('nom_client')->nullable(); // Nom optionnel si mentionné
        $table->string('contact_client')->nullable(); // Téléphone ou email optionnel
        $table->decimal('montant_total', 10, 2);
        $table->decimal('montant_regle', 10, 2);
        $table->decimal('montant_du', 10, 2)->default(0);
        $table->enum('mode_paiement', ['especes', 'carte', 'mobile', 'virement', 'autre']);
        $table->boolean('est_complete')->default(true);
        $table->text('remarques')->nullable();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('cabine_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });

    Schema::create('ligne_ventes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('vente_id')->constrained('ventes')->onDelete('cascade');
        $table->foreignId('produit_id')->constrained();
        $table->integer('quantite');
        $table->decimal('prix_unitaire', 10, 2);
        $table->decimal('prix_achat', 10, 2); // ✅ ajouté ici
        $table->decimal('sous_total', 10, 2);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventes');
    }
};
