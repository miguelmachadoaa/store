<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use App\Models\PaymentReport;
use App\Models\PaymentMethod;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = app()->make(\App\Http\Controllers\CartController::class)->getCartItems();

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $user = auth()->user() ?? new User();
        $paymentMethods = PaymentMethod::get();

        return view('checkout.index', compact('cart', 'user', 'paymentMethods'));
    }

    public function process(Request $request)
    {
        $rules = [
            'phone' => 'required|string|max:20',
            'rif' => 'required|string|max:20',
            'address' => 'required|string',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ];

        if (!auth()->check()) {
            $rules['name'] = 'required|string|max:255';
            $rules['email'] = 'required|email|max:255';
        }

        $request->validate($rules);

        $method = PaymentMethod::find($request->payment_method_id);
        $cart = app()->make(\App\Http\Controllers\CartController::class)->getCartItems();

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        // Determinar u obtener el usuario
        if (auth()->check()) {
            $user = auth()->user();
            $user->update([
                'phone' => $request->phone,
                'rif' => $request->rif,
                'address' => $request->address,
            ]);
        } else {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'rif' => $request->rif,
                    'address' => $request->address,
                    'password' => Hash::make(Str::random(16)),
                ]);
            }
        }

        $total = 0;
        $totalTaxableBase = 0;
        $totalTaxAmount = 0;
        $exchangeRate = Product::getDollarRate();

        $itemsToCreate = [];
        $stripeLineItems = [];

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

            // Construir ítems para Stripe (precio en centavos USD)
            $stripeLineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                    'unit_amount' => (int) round($item['price'] * 100),
                ],
                'quantity' => $item['quantity'],
            ];
        }

        // Calcular descuento si existe cupon
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

        // Crear la orden con estado 'pendiente'
        $order = Order::create([
            'user_id' => $user->id,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_rif' => $request->rif,
            'address' => $request->address,
            'payment_method_id' => $method->id, 
            'payment_method'    => $method->name,
            'status'            => 'pendiente',
            'total' => $total,
            'total_bs' => $total * $exchangeRate,
            'taxable_base' => $totalTaxableBase * $exchangeRate,
            'tax_amount' => $totalTaxAmount * $exchangeRate,
            'exchange_rate' => $exchangeRate,
            'coupon_id' => $couponId,
            'discount_amount' => $discountAmount,
        ]);

        foreach ($itemsToCreate as $itemData) {
            $itemData['order_id'] = $order->id;
            OrderItem::create($itemData);
        }

        // Vaciar el carrito
        if (auth()->check()) {
            auth()->user()->cart()->delete(); 
        }
        session()->forget('cart'); 
        session()->forget('coupon');

        // 💳 EVALUAR SI EL MÉTODO DE PAGO ES STRIPE
        if (in_array(strtolower($method->type), ['stripe', 'card'])) {
            Stripe::setApiKey(config('services.stripe.secret'));

            $checkoutSession = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => $stripeLineItems,
                'mode' => 'payment',
                'customer_email' => $user->email,
                'client_reference_id' => $order->id,
                'success_url' => route('stripe.success', ['order' => $order->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('stripe.cancel', ['order' => $order->id]),
            ]);

            return redirect()->away($checkoutSession->url);
        }

        return redirect()->route('checkout.success', $order->id);
    }

    // Callbacks de respuesta de Stripe
    public function stripeSuccess(Request $request, Order $order)
    {
        $sessionId = $request->get('session_id');

        if ($sessionId) {
            Stripe::setApiKey(config('services.stripe.secret'));
            $session = StripeSession::retrieve($sessionId);

            if ($session && $session->payment_status === 'paid') {

                // 1. Actualizamos el estado de la orden
                $order->update([
                    'status' => 'pagada',
                ]);

                // 2. Verificamos si ya se registró el pago para no duplicarlo si el usuario recarga la página
                $existingReport = PaymentReport::where('order_id', $order->id)
                    ->where('reference_number', $session->payment_intent ?? $sessionId)
                    ->first();

                if (!$existingReport) {
                    // 3. Creamos el registro del reporte de pago automáticamente
                    PaymentReport::create([
                        'order_id'         => $order->id,
                        'user_id'          => $order->user_id,
                        'amount'           => $order->total,                   // Monto en USD
                        'amount_bs'        => $order->total_bs,                // Monto equivalente en Bolívares
                        'reference_number' => $session->payment_intent ?? $sessionId, // ID único de la transacción en Stripe
                        'bank_name'        => 'Stripe',
                        'payment_date'     => now(),
                        'status'           => 'approved',                      // Queda aprobado automáticamente
                        'notes'            => 'Pago automático procesado vía Stripe Checkout.'
                    ]);
                }
            }
        }

        return redirect()->route('checkout.success', $order->id)
            ->with('success', '¡Pago procesado y registrado exitosamente con Stripe!');
    }

    public function stripeCancel(Order $order)
    {
        return redirect()->route('checkout.index')->with('error', 'El pago a través de Stripe fue cancelado.');
    }

    public function success($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);

        $viewOrderUrl = URL::signedRoute('guest.order.show', ['orderId' => $order->id]);
        $reportPaymentUrl = URL::signedRoute('guest.payments.report', ['orderId' => $order->id]);

        return view('checkout.success', compact('order', 'viewOrderUrl', 'reportPaymentUrl'));
    }

    // ... (demás métodos como downloadInvoice, guestViewOrder, etc. se mantienen igual) ...
}