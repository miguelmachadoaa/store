<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'name',
        'price',
        'quantity',
        'total_bs',
        'exchange_rate',
        'tax_id',
        'tax_rate',
        'taxable_base',
        'tax_amount',
    ];

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }
}
