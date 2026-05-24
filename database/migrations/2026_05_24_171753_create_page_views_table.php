<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('session_id')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            
            // Relación polimórfica (Permite asociar opcionalmente un Producto, Categoría, etc.)
            $table->nullableMorphs('viewable'); 
            
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps(); // create_at será nuestra fecha de visita
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};