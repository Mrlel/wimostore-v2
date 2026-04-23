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
         Schema::create('notifications_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cabine_id')->constrained();
            $table->foreignId('produit_id')->constrained();
            $table->enum('type', ['faible', 'rupture']);
            $table->string('message');
            $table->boolean('vu')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications_stocks');
    }
};
