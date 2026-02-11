<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceTestimonial extends Model
{
    protected $fillable = [
        'service_id',
        'client_name',
        'client_position',
        'client_company',
        'client_avatar',
        'testimonial',
        'rating',
        'is_featured',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_featured' => 'boolean',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
