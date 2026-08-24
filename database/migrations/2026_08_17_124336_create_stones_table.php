<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stones', function (Blueprint $table) {
            $table->id();
            $table->string('name');                          // Ej: "Ojo de Tigre"
            $table->string('slug')->unique();                 // Ej: "ojo-de-tigre" (para URLs amigables)
            $table->string('subtitle')->nullable();          // Ej: "Fuerza, coraje y confianza" (como en la imagen)
            $table->text('short_description');               // Para tarjetas / listados
            $table->longText('description');                 // Contenido detallado de la página
            $table->string('image')->nullable();             // Ruta de la imagen principal
            $table->json('benefits')->nullable();            // Array de beneficios (ej: ["Protección", "Fuerza"])
            $table->json('chakras')->nullable();             // Array de chakras asociados (ej: ["Raíz", "Plexo Solar"])
            $table->string('zodiac_signs')->nullable();      // Ej: "Aries, Tauro, Leo"
            $table->boolean('is_active')->default(true);     // Para activar/desactivar visibilidad
            $table->integer('sort_order')->default(0);       // Para ordenar las piedras en el grid
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stones');
    }
};