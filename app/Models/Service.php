<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'hero_title',
        'hero_subtitle',
        'hero_image',
        'hero_cta_text',
        'hero_cta_link',
        'features',
        'icon',
        'image',
        'price',
        'price_description',
        'is_active',
        'is_featured',
        'order',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->name);
            }
        });

        static::updating(function ($service) {
            if ($service->isDirty('name')) {
                $service->slug = Str::slug($service->name);
            }
        });
    }

    public function sections()
    {
        return $this->hasMany(ServiceSection::class)->orderBy('order');
    }

    public function testimonials()
    {
        return $this->hasMany(ServiceTestimonial::class);
    }

    public function featuredTestimonials()
    {
        return $this->hasMany(ServiceTestimonial::class)->where('is_featured', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    public function getFeaturesArrayAttribute()
    {
        return is_array($this->features) ? $this->features : [];
    }
}
