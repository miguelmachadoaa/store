<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'url', 'icon', 'sort_order', 'is_active'];

    public static function commonIcons()
    {
        return [
            'fab fa-whatsapp' => 'WhatsApp',
            'fas fa-shopping-cart' => 'Tienda Virtual / Carrito',
            'fab fa-instagram' => 'Instagram',
            'fab fa-tiktok' => 'TikTok',
            'fab fa-facebook' => 'Facebook',
            'fas fa-envelope' => 'Correo Electrónico',
            'fas fa-phone' => 'Llamada Directa',
            'fas fa-map-marker-alt' => 'Ubicación / Google Maps',
            'fas fa-info-circle' => 'Sobre Nosotros / FAQ',
            'fas fa-file-alt' => 'Catálogo PDF / Términos',
            'fas fa-globe' => 'Sitio Web Oficial',
        ];
    }
}