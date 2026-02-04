<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('rif')->nullable()->after('phone');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_rif')->nullable()->after('customer_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('rif');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('customer_rif');
        });
    }
};
