<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Guardará el path del logo exclusivo de linktree (o usa el global si está vacío)
            $table->string('linktree_logo')->nullable();
            // Paleta de colores Hexadecimales
            $table->string('linktree_bg_type')->default('gradient'); // 'gradient', 'solid', 'image'
            $table->string('linktree_bg_color')->default('#111827'); // Fondo sólido o inicio del gradiente
            $table->string('linktree_bg_gradient_to')->default('#312e81'); // Fin del gradiente (si aplica)
            $table->string('linktree_bg_image')->nullable(); // Imagen de fondo personalizada
            $table->string('linktree_button_bg')->default('rgba(255,255,255,0.1)'); // Color del botón
            $table->string('linktree_button_text')->default('#ffffff'); // Color del texto del botón
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'linktree_logo', 'linktree_bg_type', 'linktree_bg_color', 
                'linktree_bg_gradient_to', 'linktree_bg_image', 
                'linktree_button_bg', 'linktree_button_text'
            ]);
        });
    }
};