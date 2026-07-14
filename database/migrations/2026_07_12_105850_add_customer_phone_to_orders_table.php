<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function column_exists($table, $column) {
        return Schema::hasColumn($table, $column);
    }

    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Modificamos user_id para que acepte nulos si es un invitado
            $table->foreignId('user_id')->nullable()->change();

            // Agregamos el campo para el teléfono del cliente de esta orden específica
            if (!Schema::hasColumn('orders', 'customer_phone')) {
                $table->string('customer_phone', 20)->nullable()->after('customer_email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Revertimos los cambios si es necesario
            $table->foreignId('user_id')->nullable(false)->change();
            
            if (Schema::hasColumn('orders', 'customer_phone')) {
                $table->dropColumn('customer_phone');
            }
        });
    }
};