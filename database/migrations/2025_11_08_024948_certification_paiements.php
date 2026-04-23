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
        Schema::create('certification_paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cabine_id')->constrained()->onDelete('cascade');
            $table->decimal('montant', 10, 2)->default(10000); // 10 000 FCFA
            $table->enum('statut', ['en_attente', 'paye', 'annule'])->default('en_attente');
            $table->string('reference_paiement')->nullable(); // Token MoneyFusion
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certification_paiements');
    }
};
