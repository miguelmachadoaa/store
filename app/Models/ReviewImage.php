<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ReviewImage extends Model
{
    use HasFactory;

    protected $fillable = ['review_id', 'image_path'];

    public function getUrlAttribute(): ?string
    {
        return $this->image_path ? Storage::disk('r2')->url($this->image_path) : null;
    }

    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}
