<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'is_active',
        'is_featured', 
        'parent_id',   
        'image',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /* =====================================================================
       RELACIONES JERÁRQUICAS (Padres / Hijas)
       ===================================================================== */

    /**
     * Obtiene la categoría padre de la categoría actual.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Obtiene las subcategorías (hijas) de la categoría actual.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /* =====================================================================
       SCOPES DE CONSULTA (Para el Frontend)
       ===================================================================== */

    /**
     * Filtra solo las categorías principales (Raíz / Sin padre).
     */
    public function scopeOnlyParents($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Filtra solo las categorías que están marcadas como destacadas.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Filtra solo las categorías activas.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /* =====================================================================
       RELACIONES CON PRODUCTOS
       ===================================================================== */

    public function productsOld()
    {
        return $this->hasMany(Product::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}