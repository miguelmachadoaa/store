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
        Schema::create('coupons', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('code')->unique();
            $blueprint->enum('type', ['porcentaje', 'monto_fijo']);
            $blueprint->decimal('value', 10, 2);
            $blueprint->boolean('is_active')->default(true);
            $blueprint->dateTime('start_date')->nullable();
            $blueprint->dateTime('expires_at')->nullable();
            $blueprint->integer('usage_limit')->nullable();
            $blueprint->integer('used_count')->default(0);
            $blueprint->decimal('min_order_amount', 10, 2)->nullable();
            $blueprint->boolean('first_purchase_only')->default(false);
            $blueprint->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $blueprint->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
