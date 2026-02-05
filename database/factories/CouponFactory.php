<?php

namespace Database\Factories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    protected $model = Coupon::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper($this->faker->unique()->lexify('????-????')),
            'type' => $this->faker->randomElement(['porcentaje', 'monto_fijo']),
            'value' => $this->faker->randomFloat(2, 5, 50),
            'is_active' => true,
            'start_date' => now(),
            'expires_at' => now()->addDays(30),
            'usage_limit' => $this->faker->optional()->numberBetween(10, 100),
            'used_count' => 0,
            'min_order_amount' => $this->faker->optional()->randomFloat(2, 20, 100),
            'first_purchase_only' => false,
        ];
    }
}
