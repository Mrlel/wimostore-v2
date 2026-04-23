<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cabine_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cabine_id')->constrained()->onDelete('cascade');
            $table->string('logo')->nullable();   
            $table->string('nom_site'); 
            $table->string('titre');
            $table->string('sous_titre');
            $table->string('description');     
            $table->string('banniere');           
            $table->string('telephone');
            $table->string('whatsapp')->nullable();
            $table->string('facebook')->nullable();
            $table->string('email')->nullable();
            $table->string('instagram')->nullable();
            
            // Coordonnées géographiques
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            
            $table->boolean('est_publiee')->default(false); // Publication publique ou pas

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cabine_pages');
    }
};
