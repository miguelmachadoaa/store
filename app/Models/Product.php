<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    // Helper estático para obtener la tasa del día (cacheable si se quisiera)
    public static function getDollarRate()
    {
        return \App\Models\DollarValue::latest('date')->first()?->value ?? 0;
    }

    // Accessor para precio en Bolívares
    public function getPriceBsAttribute()
    {
        $rate = self::getDollarRate();

        return $this->price * $rate;
    }

    // Accessor para precio comparativo en Bolívares
    public function getComparePriceBsAttribute()
    {
        if (! $this->compare_price) {
            return 0;
        }
        $rate = self::getDollarRate();

        return $this->compare_price * $rate;
    }

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'compare_price',
        'stock',
        'sku',
        'image',
        'is_active',
        'is_featured',
        'category_id',
        'tax_id',
        'meta_title',
        'meta_description',
        'view_type',
        'landing_headline',
        'landing_subheadline',
        'landing_video_url',
        'landing_benefits',
        'landing_target_public',
        'landing_testimonials',
        'landing_bonuses',
        'landing_warranty_days',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'tax_id' => 'integer',
        'view_type' => 'string',
        'landing_benefits' => 'array',
        'landing_target_public' => 'array',
        'landing_testimonials' => 'array',
        'landing_bonuses' => 'array',
        'landing_warranty_days' => 'integer',
    ];

    /**
     * Boot function para generar slug automáticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    /**
     * Scope para productos activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para productos destacados
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope para productos en stock
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Obtener el precio con descuento si existe
     */
    public function getDiscountPercentageAttribute()
    {
        if ($this->compare_price && $this->compare_price > $this->price) {
            return round((($this->compare_price - $this->price) / $this->compare_price) * 100);
        }

        return 0;
    }

    /**
     * Verificar si el producto tiene descuento
     */
    public function hasDiscount()
    {
        return $this->compare_price && $this->compare_price > $this->price;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class)->withDefault([
            'name' => 'Exento',
            'rate' => 0,
        ]);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'wishlists');
    }

    public function isFavoritedBy(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->favoritedBy()->where('user_id', $user->id)->exists();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function getAverageRatingAttribute()
    {
        return round($this->approvedReviews()->avg('rating') ?? 0, 1);
    }

    public function hasUserPurchased(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return \App\Models\Order::where('user_id', $user->id)
            ->where('status', 'pagada')
            ->whereHas('items', function ($query) {
                $query->where('product_id', $this->id);
            })->exists();
    }

    // En App/Models/Product.php
    public function orders()
    {
        return $this->hasManyThrough(Order::class, OrderItem::class);
    }

    
}
