<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'is_active',
        'start_date',
        'expires_at',
        'usage_limit',
        'used_count',
        'min_order_amount',
        'first_purchase_only',
        'category_id',
        'brand_id',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'is_active' => 'boolean',
            'start_date' => 'datetime',
            'expires_at' => 'datetime',
            'usage_limit' => 'integer',
            'used_count' => 'integer',
            'min_order_amount' => 'decimal:2',
            'first_purchase_only' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Check if the coupon is valid for application.
     */
    public function isValid(?User $user = null, float $cartTotal = 0): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = Carbon::now();

        if ($this->start_date && $now->lt($this->start_date)) {
            return false;
        }

        if ($this->expires_at && $now->gt($this->expires_at)) {
            return false;
        }

        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return false;
        }

        if ($this->min_order_amount !== null && $cartTotal < $this->min_order_amount) {
            return false;
        }

        if ($this->first_purchase_only && $user) {
            if ($user->orders()->where('status', '!=', 'cancelada')->exists()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Calculate discount amount for a given cart.
     */
    public function calculateDiscount(float $cartTotal, iterable $cartItems = []): float
    {
        $discount = 0;

        // If coupon is restricted to category or brand, calculate based on matching items
        if ($this->category_id || $this->brand_id) {
            $applicableTotal = 0;
            foreach ($cartItems as $item) {
                $categoryId = null;
                $brandId = null;
                $itemPrice = 0;
                $itemQty = 0;

                if (is_array($item)) {
                    $categoryId = $item['category_id'] ?? null;
                    $brandId = $item['brand_id'] ?? null;
                    $itemPrice = $item['price'] ?? 0;
                    $itemQty = $item['quantity'] ?? 0;

                    // Fallback to DB if IDs are missing but product_id is present
                    if (($categoryId === null || $brandId === null) && isset($item['product_id'])) {
                        $product = Product::find($item['product_id']);
                        if ($product) {
                            $categoryId = $product->category_id;
                            $brandId = $product->brand_id;
                        }
                    }
                } else {
                    $categoryId = $item->product->category_id ?? null;
                    $brandId = $item->product->brand_id ?? null;
                    $itemPrice = $item->product->price ?? 0;
                    $itemQty = $item->quantity ?? 0;
                }

                $matchesCategory = !$this->category_id || $categoryId == $this->category_id;
                $matchesBrand = !$this->brand_id || $brandId == $this->brand_id;

                if ($matchesCategory && $matchesBrand) {
                    $applicableTotal += $itemPrice * $itemQty;
                }
            }

            if ($this->type === 'porcentaje') {
                $discount = ($applicableTotal * $this->value) / 100;
            } else { // monto_fijo
                // Fixed discount cannot exceed applicable total
                $discount = min($this->value, $applicableTotal);
            }
        } else {
            // General discount
            if ($this->type === 'porcentaje') {
                $discount = ($cartTotal * $this->value) / 100;
            } else {
                $discount = min($this->value, $cartTotal);
            }
        }

        return round($discount, 2);
    }
}
