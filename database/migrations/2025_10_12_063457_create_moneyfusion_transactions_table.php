<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('moneyfusion_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();
            $table->string('event')->nullable();
            $table->string('statut')->nullable();
            $table->json('payload')->nullable();
            $table->boolean('processed')->default(false);
            $table->unsignedBigInteger('abonnement_id')->nullable();
            $table->integer('montant')->nullable();
            $table->timestamps();

            $table->foreign('abonnement_id')->references('id')->on('abonnements')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moneyfusion_transactions');
    }
};
