<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use App\Services\CartDiscountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected CartDiscountService $discountService;

    public function __construct(CartDiscountService $discountService)
    {
        $this->discountService = $discountService;
    }

    /**
     * Helper central para calcular Subtotal, Descuentos Automáticos, Cupones y Totales.
     */
    public function getCartTotals(): array
    {
        $items = $this->getCartItems();
        $subtotal = 0;

        foreach ($items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // 1. Cálculo de descuento por volumen (diferentes modelos de pulseras)
        $autoDiscount = $this->discountService->calculateAutomaticDiscount($items);

        // 2. Cupón manual desde la sesión
        $couponSession = session()->get('coupon', null);
        $couponDiscount = $couponSession ? $couponSession['discount'] : 0;

        // Reglas de envío
        $envioGratisMinimo = 20.00;
        $costoEnvioBase = 3.00;
        
        $costoEnvio = $subtotal >= $envioGratisMinimo ? 0 : $costoEnvioBase;
        $faltaParaGratis = max(0, $envioGratisMinimo - $subtotal);
        $porcentajeProgreso = min(($subtotal / $envioGratisMinimo) * 100, 100);

        // Descuento total combinado
        $totalDiscount = $autoDiscount['discount_amount'] + $couponDiscount;
        $total = max(0, $subtotal - $totalDiscount + $costoEnvio);

        return [
            'items'               => $items,
            'subtotal'            => $subtotal,
            'auto_discount'       => $autoDiscount,
            'coupon_discount'     => $couponDiscount,
            'total_discount'      => $totalDiscount,
            'costo_envio'         => $costoEnvio,
            'costo_envio_base'    => $costoEnvioBase,
            'falta_para_gratis'   => $faltaParaGratis,
            'porcentaje_progreso' => $porcentajeProgreso,
            'total'               => $total,
        ];
    }

    public function index()
    {
        $cartTotals = $this->getCartTotals();

        return view('cart.index', [
            'cart'        => $cartTotals['items'],
            'cartTotals'  => $cartTotals,
        ]);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $coupon = Coupon::where('code', $request->code)->first();

        if (! $coupon) {
            return redirect()->back()->with('error', 'Código de cupón no válido.');
        }

        $items = $this->getCartItems();
        $subtotal = array_reduce($items, fn($sum, $i) => $sum + ($i['price'] * $i['quantity']), 0);

        if (! $coupon->isValid(Auth::user(), $subtotal)) {
            return redirect()->back()->with('error', 'El cupón no es válido o ha expirado.');
        }

        session()->put('coupon', [
            'code'     => $coupon->code,
            'discount' => $coupon->calculateDiscount($subtotal, $items),
        ]);

        return redirect()->back()->with('success', 'Cupón aplicado correctamente.');
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return redirect()->back()->with('success', 'Cupón removido.');
    }

    public function add(Request $request, $id)
    {
        $this->addItemToCart($id, $request->get('quantity', 1));
        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }

    public function update(Request $request, $id)
    {
        $this->updateItemQuantity($id, $request->quantity);

        if ($request->ajax() || $request->wantsJson()) {
            $totals = $this->getCartTotals();

            return response()->json([
                'success'               => true,
                'count'                 => count($totals['items']),
                'quantity'              => $request->quantity,
                'subtotal'              => number_format($totals['subtotal'], 2),
                'auto_discount_amount'  => number_format($totals['auto_discount']['discount_amount'], 2),
                'total'                 => number_format($totals['total'], 2),
            ]);
        }

        return redirect()->back();
    }

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
            'count'   => count($cart),
            'quantity'=> $quantity,
        ]);
    }

    public function getCart()
    {
        $sessionId = session()->getId();
        $userId = Auth::check() ? Auth::id() : null;

        return Cart::firstOrCreate(
            ['user_id' => $userId, 'session_id' => $sessionId],
            ['user_id' => $userId, 'session_id' => $sessionId]
        );
    }

    public function getCartItems(): array
    {
        $cart = $this->getCart();
        $items = [];

        foreach ($cart->items as $item) {
            $items[$item->product_id] = [
                'product_id'  => $item->product_id,
                'name'        => $item->product->name,
                'price'       => $item->product->price,
                'image'       => $item->product->image,
                'quantity'    => $item->quantity,
                'category_id' => $item->product->category_id,
                'brand_id'    => $item->product->brand_id,
            ];
        }

        return $items;
    }

    private function addItemToCart(int $productId, int $quantityToAdd = 1): void
    {
        $cart = $this->getCart();
        $product = Product::findOrFail($productId);

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

    private function updateItemQuantity(int $productId, int $quantity): void
    {
        $cart = $this->getCart();
        $item = $cart->items()->where('product_id', $productId)->first();

        if ($item) {
            if ($quantity <= 0) {
                $item->delete();
            } else {
                $item->update(['quantity' => $quantity]);
            }
        }
    }

    private function removeItemFromCart(int $productId): void
    {
        $cart = $this->getCart();
        $cart->items()->where('product_id', $productId)->delete();
    }

    public function mergeSessionCartIntoDatabase(): void
    {
        if (! Auth::check()) return;

        $sessionCart = session()->get('cart', []);
        if (empty($sessionCart)) return;

        foreach ($sessionCart as $productId => $item) {
            $this->addItemToCart($productId, $item['quantity'] ?? 1);
        }

        session()->forget('cart');
    }

    public function buyNow(Request $request, $id)
    {
        $this->addItemToCart($id, $request->get('quantity', 1));
        return redirect()->route('checkout.index')->with('success', 'Producto listo para comprar.');
    }
}