<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        $name = $this->faker->words(3, true);
        $icons = ['🚀', '💼', '📊', '🎯', '💡', '⚡', '🔧', '📱', '🌟', '🎨'];

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'short_description' => $this->faker->sentence(12),
            'description' => $this->faker->paragraphs(3, true),
            'hero_title' => $this->faker->sentence(6),
            'hero_subtitle' => $this->faker->sentence(10),
            'hero_cta_text' => $this->faker->randomElement(['Comenzar Ahora', 'Solicitar Demo', 'Contactar', 'Más Información']),
            'hero_cta_link' => '#contacto',
            'features' => $this->faker->randomElements([
                'Soporte 24/7',
                'Garantía de satisfacción',
                'Resultados medibles',
                'Equipo experto',
                'Tecnología de punta',
                'Precios competitivos',
                'Atención personalizada',
                'Entrega rápida',
            ], $this->faker->numberBetween(4, 6)),
            'icon' => $this->faker->randomElement($icons),
            'price' => $this->faker->optional(0.7)->randomFloat(2, 99, 999),
            'price_description' => $this->faker->randomElement(['por mes', 'por proyecto', 'por año', 'único pago']),
            'is_active' => true,
            'is_featured' => $this->faker->boolean(30),
            'order' => $this->faker->numberBetween(0, 10),
            'meta_title' => ucfirst($name).' - '.config('app.name'),
            'meta_description' => $this->faker->sentence(20),
        ];
    }
}
