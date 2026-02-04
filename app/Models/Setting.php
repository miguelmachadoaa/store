<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'address',
        'phone',
        'rif',
        'email',
        'currency_preference',
    ];

    /**
     * Helper para saber qué mostrar
     */
    public function showUsd()
    {
        return in_array($this->currency_preference, ['usd', 'both']);
    }

    public function showBs()
    {
        return in_array($this->currency_preference, ['bs', 'both']);
    }
}
