<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'customer_rif',
        'address',
        'payment_method',
        'total',
        'total_bs',
        'taxable_base',
        'tax_amount',
        'exchange_rate',
        'status',
        'coupon_id',
        'discount_amount',
    ];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

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

    public function paymentReports()
    {
        return $this->hasMany(PaymentReport::class);
    }

    public function comments()
    {
        return $this->hasMany(OrderComment::class)->latest(); // El más reciente primero
    }

}
