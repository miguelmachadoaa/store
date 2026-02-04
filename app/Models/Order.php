<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_email',
        'address',
        'payment_method',
        'total',
        'total_bs',
        'exchange_rate',
        'status',
    ];


    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'pendiente' => 'bg-yellow-100 text-yellow-800',
            'pagada' => 'bg-green-100 text-green-800',
            'enviada' => 'bg-blue-100 text-blue-800',
            'cancelada' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

}
