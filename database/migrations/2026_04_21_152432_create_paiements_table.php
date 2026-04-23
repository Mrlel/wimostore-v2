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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('abonnement_id')->constrained()->onDelete('cascade');
            $table->string('reference_paiement')->unique();
            $table->decimal('montant', 10, 2);
            $table->string('periode'); // ex: "2024-01", "2024-02" ou "Renouvellement 1"
            $table->enum('statut', ['en_attente', 'payé', 'échoué'])->default('en_attente');
            $table->string('transaction_id')->nullable(); // ID FedaPay/CinetPay
            $table->string('provider')->default('fedapay'); // fedapay, cinetpay, etc.
            $table->json('provider_data')->nullable();
            $table->timestamp('paye_le')->nullable();
            $table->timestamps();
            
            $table->index(['abonnement_id', 'statut']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
