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
        'use_brevo',
        'linktree_logo',
        'linktree_bg_type',
        'linktree_bg_color',
        'linktree_bg_gradient_to',
        'linktree_bg_image',
        'linktree_button_bg',
        'linktree_button_text'
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
