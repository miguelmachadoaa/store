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

    public function getCart()
    {
        $sessionId = session()->getId();

        $userId = Auth::check() ? Auth::id() : null;

        $cart = Cart::firstOrCreate(
            ['user_id' => $userId, 'session_id' => $sessionId],
            ['user_id' => $userId, 'session_id' => $sessionId]
        );

        return $cart;
    }

    /**
     * Helper to get cart items from session or database.
     */
    public function getCartItems(): array
    {

        $cart = $this->getCart();

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

    /**
     * Helper to add an item to the cart.
     */
    private function addItemToCart(int $productId, int $quantityToAdd = 1): void
    {
        $cart = $this->getCart();
    
        $product = Product::findOrFail($productId);

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
       
    }

    /**
     * Helper to update item quantity.
     */
    private function updateItemQuantity(int $productId, int $quantity): void
    {
        $cart = $this->getCart();


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

    /**
     * Helper to remove an item from the cart.
     */
    private function removeItemFromCart(int $productId): void
    {
        $cart = $this->getCart();

        $cart->items()->where('product_id', $productId)->delete();

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

    public function buyNow(Request $request, $id)
    {
        // Reutilizamos tu helper interno para meter el producto al carrito (BD o Sesión)
        $this->addItemToCart($id, $request->get('quantity', 1));

        // Redireccionamos a la pantalla de pago
        // Cambia 'checkout.index' por el nombre real de tu ruta de checkout si es diferente
        return redirect()->route('checkout.index')->with('success', 'Producto listo para comprar.');
    }
}
