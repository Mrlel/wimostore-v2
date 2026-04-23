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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('email')->nullable();
            $table->string('numero', 20)->unique();
            $table->string('password');
            $table->enum('role', ['superadmin','admin','user','responsable']);
            $table->boolean('accept_politique')->default(false);

            // new columns for referral system
            $table->string('code_parrain')->nullable()->unique();
            $table->foreignId('parrain_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('parrainage_accepte_at')->nullable();

            $table->foreignId('cabine_id')->constrained()->onDelete('cascade');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('parrainages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parrain_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('filleul_id')->constrained('users')->onDelete('cascade');
            $table->enum('statut', ['en_attente', 'actif', 'recompense_attribuee'])->default('en_attente');
            $table->decimal('recompense_parrain', 10, 2)->default(0);
            $table->decimal('recompense_filleul', 10, 2)->default(0);
            $table->timestamp('recompense_attribuee_at')->nullable();
            $table->timestamps();

            $table->unique('filleul_id'); // Un utilisateur ne peut avoir qu'un seul parrain
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parrainages');
        Schema::dropIfExists('users');
    }
};
