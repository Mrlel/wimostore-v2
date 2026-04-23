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
        Schema::create('retraits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cabine_id')->constrained()->onDelete('cascade');
            $table->string('tokenPay')->unique();
            $table->string('numeroRetrait');
            $table->string('moyen');
            $table->integer('montant');
            $table->enum('statut', ['en_attente','effectue','annule'])->default('en_attente');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retraits');
    }
};
