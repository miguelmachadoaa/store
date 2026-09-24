<?php

namespace App\Services;

class CartDiscountService
{
    /**
     * Calcula los descuentos automáticos por volumen de items en el carrito.
     *
     * @param array $items
     * @return array
     */
    public function calculateAutomaticDiscount(array $items): array
    {
        $totalItemsCount = 0;
        $subtotalElegible = 0;

        // 1. Contamos la cantidad total de productos elegibles (ej. pulseras o todo el carrito)
        foreach ($items as $item) {
            // Opcional: Si quieres limitar el descuento a una categoría específica, 
            // evalúas $item['category_id'] == ID_CATEGORIA_PULSERAS
            $totalItemsCount += $item['quantity'];
            $subtotalElegible += $item['price'] * $item['quantity'];
        }

        $discountPercent = 0;
        $tierName = '';
        $freeShipping = false;

        // 2. Definimos los tramos de descuento según la cantidad total
        if ($totalItemsCount >= 3) {
            $discountPercent = 0.2; // 20% de descuento
            $tierName = 'Lleva 3 o más (20% OFF )';
            $freeShipping = true;
        } elseif ($totalItemsCount === 2) {
            $discountPercent = 0.05; // 5% de descuento
            $tierName = 'Lleva 2 unidades (5% OFF)';
        }

        $discountAmount = $subtotalElegible * $discountPercent;

        return [
            'total_quantity' => $totalItemsCount,
            'discount_amount' => $discountAmount,
            'discount_percent' => $discountPercent * 100,
            'label' => $tierName,
            'free_shipping' => $freeShipping,
        ];
    }
}