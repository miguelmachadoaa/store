<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceSection extends Model
{
    protected $fillable = [
        'service_id',
        'title',
        'content',
        'image',
        'type',
        'order',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
