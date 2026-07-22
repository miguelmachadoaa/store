<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CartService
{
    /**
     * Obtiene o crea el carrito activo en la base de datos.
     */
    public function getOrCreateCart(): Cart
    {
        if (Auth::check()) {
            $user = Auth::user();

            $cart = $user->cart()->firstOrCreate([
                'user_id' => $user->id,
            ]);

            // Si traía un carrito de invitado en esta sesión, lo migramos
            $guestCart = Cart::where('session_id', session()->getId())
                ->whereNull('user_id')
                ->first();

            if ($guestCart && $guestCart->id !== $cart->id) {
                $this->mergeCarts($guestCart, $cart);
            }

            return $cart;
        }

        return Cart::firstOrCreate([
            'session_id' => session()->getId(),
            'user_id'    => null,
        ]);
    }

    /**
     * Obtiene los ítems del carrito activo cargando la relación del producto.
     */
    public function getCartItems(): array
    {
        if (auth()->check()) {
            $dbCart = auth()->user()->cart()->with('product')->get();
            $cart = [];

            foreach ($dbCart as $item) {
                if ($item->product) {
                    $cart[$item->product_id] = [
                        'name'     => $item->product->name,
                        'price'    => $item->product->price,
                        'quantity' => $item->quantity,
                        'image'    => $item->product->image ?? null,
                    ];
                }
            }
            return $cart;
        }

        return session()->get('cart', []);
    }

    public function clearCart(): void
    {
        if (auth()->check()) {
            auth()->user()->cart()->delete();
        }
        session()->forget('cart');
    }

    /**
     * Añade un producto al carrito.
     */
    public function addItemToCart(int $productId, int $quantityToAdd = 1): void
    {
        Product::findOrFail($productId);

        $cart = $this->getOrCreateCart();
        $item = $cart->items()->where('product_id', $productId)->first();

        if ($item) {
            $item->increment('quantity', $quantityToAdd);
        } else {
            $cart->items()->create([
                'product_id' => $productId,
                'quantity'   => $quantityToAdd,
            ]);
        }
    }

    /**
     * Actualiza la cantidad de un ítem.
     */
    public function updateItemQuantity(int $productId, int $quantity): void
    {
        $cart = $this->getOrCreateCart();
        $item = $cart->items()->where('product_id', $productId)->first();

        if ($item) {
            if ($quantity <= 0) {
                $item->delete();
            } else {
                $item->update(['quantity' => $quantity]);
            }
        }
    }

    /**
     * Elimina un ítem del carrito.
     */
    public function removeItemFromCart(int $productId): void
    {
        $cart = $this->getOrCreateCart();
        $cart->items()->where('product_id', $productId)->delete();
    }

    /**
     * Fusiona el carrito de invitado con el del usuario autenticado.
     */
    private function mergeCarts(Cart $guestCart, Cart $userCart): void
    {
        foreach ($guestCart->items as $guestItem) {
            $userItem = $userCart->items()->where('product_id', $guestItem->product_id)->first();

            if ($userItem) {
                $userItem->increment('quantity', $guestItem->quantity);
            } else {
                $userCart->items()->create([
                    'product_id' => $guestItem->product_id,
                    'quantity'   => $guestItem->quantity,
                ]);
            }
        }

        $guestCart->delete();
    }
}