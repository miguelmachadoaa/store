<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Mostrar carrito
    public function index()
    {
        $cart = $this->getCartItems();

        return view('cart.index', compact('cart'));
    }

    // Agregar producto
    public function add(Request $request, $id)
    {
        $this->addItemToCart($id);

        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }

    // Actualizar cantidad
    public function update(Request $request, $id)
    {
        $this->updateItemQuantity($id, $request->quantity);

        return redirect()->back();
    }

    // Eliminar producto
    public function remove($id)
    {
        $this->removeItemFromCart($id);

        return redirect()->back();
    }

    public function ajaxAdd(Request $request, $id)
    {
        $this->addItemToCart($id);
        $cart = $this->getCartItems();

        return response()->json([
            'success' => true,
            'count' => count($cart),
        ]);
    }

    /**
     * Helper to get cart items from session or database.
     */
    private function getCartItems(): array
    {
        if (Auth::check()) {
            $user = Auth::user();
            /** @var \App\Models\User $user */
            $cart = $user->cart()->with('items.product')->first();

            if ($cart) {
                $items = [];
                foreach ($cart->items as $item) {
                    $items[$item->product_id] = [
                        'name' => $item->product->name,
                        'price' => $item->product->price,
                        'image' => $item->product->image,
                        'quantity' => $item->quantity,
                    ];
                }

                return $items;
            }
        }

        return session()->get('cart', []);
    }

    /**
     * Helper to add an item to the cart.
     */
    private function addItemToCart(int $productId): void
    {
        $product = Product::findOrFail($productId);

        if (Auth::check()) {
            $user = Auth::user();
            /** @var \App\Models\User $user */
            $cart = $user->cart()->firstOrCreate([
                'user_id' => $user->id,
            ]);

            /** @var \App\Models\CartItem $item */
            $item = $cart->items()->where('product_id', $productId)->first();

            if ($item) {
                $item->increment('quantity');
            } else {
                $cart->items()->create([
                    'product_id' => $productId,
                    'quantity' => 1,
                ]);
            }
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$productId])) {
                $cart[$productId]['quantity']++;
            } else {
                $cart[$productId] = [
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image,
                    'quantity' => 1,
                ];
            }

            session()->put('cart', $cart);
        }
    }

    /**
     * Helper to update item quantity.
     */
    private function updateItemQuantity(int $productId, int $quantity): void
    {
        if (Auth::check()) {
            $user = Auth::user();
            /** @var \App\Models\User $user */
            $cart = $user->cart()->first();

            if ($cart) {
                /** @var \App\Models\CartItem $item */
                $item = $cart->items()->where('product_id', $productId)->first();
                if ($item) {
                    if ($quantity <= 0) {
                        $item->delete();
                    } else {
                        $item->update(['quantity' => $quantity]);
                    }
                }
            }
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$productId])) {
                if ($quantity <= 0) {
                    unset($cart[$productId]);
                } else {
                    $cart[$productId]['quantity'] = $quantity;
                }
                session()->put('cart', $cart);
            }
        }
    }

    /**
     * Helper to remove an item from the cart.
     */
    private function removeItemFromCart(int $productId): void
    {
        if (Auth::check()) {
            $user = Auth::user();
            /** @var \App\Models\User $user */
            $cart = $user->cart()->first();

            if ($cart) {
                $cart->items()->where('product_id', $productId)->delete();
            }
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$productId])) {
                unset($cart[$productId]);
                session()->put('cart', $cart);
            }
        }
    }
}
