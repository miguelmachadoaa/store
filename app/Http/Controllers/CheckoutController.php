<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = app()->make(\App\Http\Controllers\CartController::class)->getCartItems();

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $user = auth()->user();

        return view('checkout.index', compact('cart', 'user'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'rif' => 'required|string|max:20',
            'address' => 'required|string',
            'payment' => 'required|string',
        ]);

        $cart = app()->make(\App\Http\Controllers\CartController::class)->getCartItems();

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $user = auth()->user();

        // Actualizar datos del usuario si no los tiene o si han cambiado
        $user->update([
            'phone' => $request->phone,
            'rif' => $request->rif,
            'address' => $request->address,
        ]);

        $total = 0;
        $totalTaxableBase = 0;
        $totalTaxAmount = 0;
        $exchangeRate = Product::getDollarRate();

        $itemsToCreate = [];

        foreach ($cart as $productId => $item) {
            $product = Product::with('tax')->find($productId);
            $taxRate = $product->tax->rate ?? 0;

            $itemTotal = $item['price'] * $item['quantity'];
            if ($taxRate > 0) {
                $itemTaxableBase = $itemTotal / (1 + ($taxRate / 100));
                $itemTaxAmount = $itemTotal - $itemTaxableBase;
            } else {
                $itemTaxableBase = 0;
                $itemTaxAmount = 0;
            }

            $total += $itemTotal;
            $totalTaxableBase += $itemTaxableBase;
            $totalTaxAmount += $itemTaxAmount;

            $itemsToCreate[] = [
                'product_id' => $productId,
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'tax_id' => $product->tax_id,
                'tax_rate' => $taxRate,
                'taxable_base' => $itemTaxableBase * $exchangeRate,
                'tax_amount' => $itemTaxAmount * $exchangeRate,
                'total_bs' => $itemTotal * $exchangeRate,
                'exchange_rate' => $exchangeRate,
            ];
        }

        // Calcular descuento si hay cupón
        $discountAmount = 0;
        $couponId = null;
        if (session()->has('coupon')) {
            $coupon = \App\Models\Coupon::where('code', session('coupon.code'))->first();
            if ($coupon && $coupon->isValid($user, $total)) {
                $couponId = $coupon->id;
                $discountAmount = $coupon->calculateDiscount($total, $cart);
                $total -= $discountAmount;
                $coupon->increment('used_count');
            }
        }

        // Crear la orden
        $order = Order::create([
            'user_id' => $user->id,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_rif' => $request->rif,
            'address' => $request->address,
            'payment_method' => $request->payment,
            'total' => $total,
            'total_bs' => $total * $exchangeRate,
            'taxable_base' => $totalTaxableBase * $exchangeRate,
            'tax_amount' => $totalTaxAmount * $exchangeRate,
            'exchange_rate' => $exchangeRate,
            'coupon_id' => $couponId,
            'discount_amount' => $discountAmount,
        ]);

        // Crear los items de la orden
        foreach ($itemsToCreate as $itemData) {
            $itemData['order_id'] = $order->id;
            OrderItem::create($itemData);
        }

        // Vaciar carrito y cupón
        if (auth()->check()) {
            auth()->user()->cart()->delete(); // Limpia el del DB
        }
        session()->forget('cart'); // Limpia el de la sesión
        session()->forget('coupon');

        return redirect()->route('checkout.success', $order->id);
    }

    public function success($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);

        return view('checkout.success', compact('order'));
    }

    public function downloadInvoice($orderId)
    {
        $order = Order::with('items.tax')->findOrFail($orderId);

        // Security check: Only owner or admin can download
        if (auth()->user()->role !== 'admin' && $order->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para ver esta factura.');
        }

        $settings = Setting::first();

        $pdf = Pdf::loadView('pdf.invoice', compact('order', 'settings'));

        return $pdf->download('Factura_' . $order->id . '.pdf');
    }
}
