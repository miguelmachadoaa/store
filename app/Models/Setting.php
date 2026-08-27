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
        'whatsapp', // <-- Agregado a fillable
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

    /**
     * Helper para obtener solo los números del WhatsApp y usarlo en la URL wa.me
     * Ejemplo uso en Blade: <a href="https://wa.me/{{ $setting->clean_whatsapp }}">
     */
    /**
     * Helper para obtener el número de WhatsApp en formato internacional (58XXXXXXXXX).
     * Ejemplo uso en Blade: href="https://wa.me/{{ $storeSettings->clean_whatsapp }}"
     */
    public function getCleanWhatsappAttribute()
    {
        if (empty($this->whatsapp)) {
            return '';
        }

        // 1. Dejar únicamente los dígitos
        $phone = preg_replace('/[^0-9]/', '', $this->whatsapp);

        // 2. Si empieza por '0', remover el '0' inicial y anteponer '58'
        if (str_starts_with($phone, '0')) {
            $phone = '58' . substr($phone, 1);
        }
        // 3. Si el usuario ingresó 414... sin el '0' ni '58', anteponer '58'
        elseif (!str_starts_with($phone, '58')) {
            $phone = '58' . $phone;
        }

        return $phone;
    }
}