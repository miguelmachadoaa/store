<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image',
        'button_text',
        'button_link',
        'order',
        'is_active',
        'text_position',
        'text_color',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Scope para sliders activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para ordenar por orden
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Boot function para establecer orden automáticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($slider) {
            if (is_null($slider->order)) {
                $slider->order = static::max('order') + 1 ?? 0;
            }
        });
    }

    /**
     * Obtener la clase CSS para la posición del texto
     */
    public function getTextPositionClass()
    {
        return match($this->text_position) {
            'left' => 'text-left items-start',
            'center' => 'text-center items-center',
            'right' => 'text-right items-end',
            default => 'text-left items-start',
        };
    }

    /**
     * Obtener la clase CSS para el color del texto
     */
    public function getTextColorClass()
    {
        return match($this->text_color) {
            'light' => 'text-white',
            'dark' => 'text-gray-900',
            default => 'text-gray-900',
        };
    }
}