<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Aplicar cupón
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $coupon = Coupon::where('code', $request->code)->first();

        if (! $coupon) {
            return redirect()->back()->with('error', 'Código de cupón no válido.');
        }

        $items = $this->getCartItems();
        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        if (! $coupon->isValid(Auth::user(), $total)) {
            return redirect()->back()->with('error', 'El cupón no es válido o ha expirado.');
        }

        session()->put('coupon', [
            'code' => $coupon->code,
            'discount' => $coupon->calculateDiscount($total, $items),
        ]);

        return redirect()->back()->with('success', 'Cupón aplicado correctamente.');
    }

    // Quitar cupón
    public function removeCoupon()
    {
        session()->forget('coupon');

        return redirect()->back()->with('success', 'Cupón removido.');
    }

    // Mostrar carrito
    public function index()
    {
        $cart = $this->getCartItems();

        return view('cart.index', compact('cart'));
    }

    // Agregar producto
    public function add(Request $request, $id)
    {
        $this->addItemToCart($id, $request->get('quantity', 1));

        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }

    // Actualizar cantidad
    public function update(Request $request, $id)
    {
        $this->updateItemQuantity($id, $request->quantity);

        if ($request->ajax() || $request->wantsJson()) {
            $cart = $this->getCartItems();

            return response()->json([
                'success' => true,
                'count' => count($cart),
                'quantity' => $request->quantity,
            ]);
        }

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
        $this->addItemToCart($id, $request->get('quantity', 1));
        $cart = $this->getCartItems();
        $quantity = isset($cart[$id]) ? $cart[$id]['quantity'] : 0;

        return response()->json([
            'success' => true,
            'count' => count($cart),
            'quantity' => $quantity,
        ]);
    }

    /**
     * Helper to get cart items from session or database.
     */
    public function getCartItems(): array
    {
        if (Auth::check()) {
            $user = Auth::user();
            /** @var \App\Models\User $user */
            $cart = $user->cart()->with('items.product')->first();

            if ($cart) {
                $items = [];
                foreach ($cart->items as $item) {
                    $items[$item->product_id] = [
                        'product_id' => $item->product_id,
                        'name' => $item->product->name,
                        'price' => $item->product->price,
                        'image' => $item->product->image,
                        'quantity' => $item->quantity,
                        'category_id' => $item->product->category_id,
                        'brand_id' => $item->product->brand_id,
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
    private function addItemToCart(int $productId, int $quantityToAdd = 1): void
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
                $item->increment('quantity', $quantityToAdd);
            } else {
                $cart->items()->create([
                    'product_id' => $productId,
                    'quantity' => $quantityToAdd,
                ]);
            }
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $quantityToAdd;
            } else {
                $cart[$productId] = [
                    'product_id' => $productId,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image,
                    'quantity' => $quantityToAdd,
                    'category_id' => $product->category_id,
                    'brand_id' => $product->brand_id,
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

    /**
     * Merges session cart items into the authenticated user's database cart.
     */
    public function mergeSessionCartIntoDatabase(): void
    {
        if (! Auth::check()) {
            return;
        }

        $sessionCart = session()->get('cart', []);

        if (empty($sessionCart)) {
            return;
        }

        foreach ($sessionCart as $productId => $item) {
            $this->addItemToCart($productId, $item['quantity'] ?? 1);
        }

        session()->forget('cart');
    }
}
