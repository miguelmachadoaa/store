<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'subtitle',
        'short_description',
        'description',
        'image',
        'benefits',
        'chakras',
        'zodiac_signs',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'benefits' => 'array',
            'chakras' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}