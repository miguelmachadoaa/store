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
        Schema::table('payment_methods', function (Blueprint $table) {
            Schema::table('payment_methods', function (Blueprint $table) {
                $table->string('qr_code')->nullable()->after('logo');
                $table->json('bank_details')->nullable()->after('description');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropColumn(['qr_code', 'bank_details']);
        });
    }
};
