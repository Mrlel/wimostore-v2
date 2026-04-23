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
        Schema::create('cabines', function (Blueprint $table) {
            $table->id();
            $table->string('nom_cab');
            $table->string('localisation');
            $table->string('code')->unique();
            $table->boolean('est_actif')->default(true);
            $table->boolean('certifier')->default(false)->nullable();
            $table->enum('type_compte', ['admin', 'illimite', 'standard'])->default('standard');
            $table->integer('max_utilisateurs')->default(2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('cabines', function (Blueprint $table) {
            $table->dropColumn([
                'code', 'localisation', 'est_actif', 'max_utilisateurs', 'type_compte',
            ]);
        });
    }
};
