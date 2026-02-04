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
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('taxable_base', 12, 2)->after('total')->nullable();
            $table->decimal('tax_amount', 12, 2)->after('taxable_base')->nullable();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('tax_id')->nullable()->constrained('taxes')->after('product_id');
            $table->decimal('tax_rate', 5, 2)->after('tax_id')->nullable();
            $table->decimal('taxable_base', 12, 2)->after('exchange_rate')->nullable();
            $table->decimal('tax_amount', 12, 2)->after('taxable_base')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['taxable_base', 'tax_amount']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('tax_id');
            $table->dropColumn(['tax_rate', 'taxable_base', 'tax_amount']);
        });
    }
};
