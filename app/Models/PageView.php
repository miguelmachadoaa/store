<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageView extends Model
{
    protected $fillable = [
        'url', 
        'session_id', 
        'ip_address', 
        'user_agent', 
        'viewable_type', 
        'viewable_id', 
        'user_id'
    ];

    // Relación polimórfica hacia Producto/Categoría
    public function viewable(): MorphTo
    {
        return $this->morphTo();
    }

    // Usuario que visitó (si estaba logueado)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}