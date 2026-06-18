<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint as SchemaTable;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('products', function (SchemaTable $table) {
        // Estructura de la Landing Tipo Hotmart
        $table->string('view_type')->default('default')->after('is_featured');
        
        // Hero Section
        $table->string('landing_headline')->nullable(); // Título de impacto
        $table->string('landing_subheadline')->nullable(); // Subtítulo / Promesa
        $table->string('landing_video_url')->nullable(); // Link de YouTube/Vimeo
        
        // Secciones dinámicas (Se guardarán como JSON Arrays)
        $table->json('landing_benefits')->nullable(); // ¿Qué vas a lograr?
        $table->json('landing_target_public')->nullable(); // Para quién es / Para quién no
        $table->json('landing_testimonials')->nullable(); // Capturas o textos + nombres
        $table->json('landing_bonuses')->nullable(); // Los Bonus de regalo
        
        // Garantía
        $table->integer('landing_warranty_days')->default(7); // Días de garantía
    });
}

public function down(): void
{
    Schema::table('products', function (SchemaTable $table) {
        $table->dropColumn([
            'view_type', 'landing_headline', 'landing_subheadline', 
            'landing_video_url', 'landing_benefits', 'landing_target_public', 
            'landing_testimonials', 'landing_bonuses', 'landing_warranty_days'
        ]);
    });
}

    
};
