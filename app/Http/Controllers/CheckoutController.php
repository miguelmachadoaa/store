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

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = app()->make(\App\Http\Controllers\CartController::class)->getCartItems();

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        // Si el usuario es invitado, pasamos una instancia vacía de User para no romper la vista
        $user = auth()->user() ?? new User();

        $paymentMethods = PaymentMethod::get();

        return view('checkout.index', compact('cart', 'user', 'paymentMethods'));
    }

    public function process(Request $request)
    {
        // Validación base obligatoria para todos
        $rules = [
            'phone' => 'required|string|max:20',
            'rif' => 'required|string|max:20',
            'address' => 'required|string',
          #  'payment' => 'required|string',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ];

        // Si es invitado, exigimos nombre y correo electrónico
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

        // Determinar u obtener el usuario asociado a la compra
        if (auth()->check()) {
            $user = auth()->user();
            $user->update([
                'phone' => $request->phone,
                'rif' => $request->rif,
                'address' => $request->address,
            ]);
        } else {
            // Si el correo ya existe en la DB, lo usamos; si no, creamos un usuario "en caliente"
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'rif' => $request->rif,
                    'address' => $request->address,
                    'password' => Hash::make(Str::random(16)), // Contraseña aleatoria segura
                ]);
            }
        }

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

        // Calcular descuento si hay cupón en sesión
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

        // Crear la orden vinculada al usuario
        $order = Order::create([
            'user_id' => $user->id,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_rif' => $request->rif,
            'address' => $request->address,
            'payment_method_id' => $method->id, 
            'payment_method'    => $method->name,
            'total' => $total,
            'total_bs' => $total * $exchangeRate,
            'taxable_base' => $totalTaxableBase * $exchangeRate,
            'tax_amount' => $totalTaxAmount * $exchangeRate,
            'exchange_rate' => $exchangeRate,
            'coupon_id' => $couponId,
            'discount_amount' => $discountAmount,
        ]);

        // Crear los items correspondientes
        foreach ($itemsToCreate as $itemData) {
            $itemData['order_id'] = $order->id;
            OrderItem::create($itemData);
        }

        // Vaciar el carrito físico/sesión y cupones utilizados
        if (auth()->check()) {
            auth()->user()->cart()->delete(); 
        }
        session()->forget('cart'); 
        session()->forget('coupon');

        return redirect()->route('checkout.success', $order->id);
    }

    public function success($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);

        // Generación de links firmados y seguros para el flujo de invitados
        $viewOrderUrl = URL::signedRoute('guest.order.show', ['orderId' => $order->id]);
        $reportPaymentUrl = URL::signedRoute('guest.payments.report', ['orderId' => $order->id]);

        return view('checkout.success', compact('order', 'viewOrderUrl', 'reportPaymentUrl'));
    }

    public function downloadInvoice($orderId)
    {
        $order = Order::with('items.tax')->findOrFail($orderId);

        // Permitir descarga si es admin, el dueño directo logueado, o si posee una firma de URL válida (invitados)
        if (auth()->check() && (auth()->user()->role === 'admin' || $order->user_id === auth()->id())) {
            // Autorizado por sesión
        } else {
            if (!request()->hasValidSignature()) {
                abort(403, 'No tienes permiso para ver esta factura.');
            }
        }

        $settings = Setting::first();
        $pdf = Pdf::loadView('pdf.invoice', compact('order', 'settings'));

        return $pdf->download('Factura_' . $order->id . '.pdf');
    }

    // =========================================================================
    // FLUJO PÚBLICO SEGURO PARA CONSULTAS Y REPORTES DE INVITADOS (GUESTS)
    // =========================================================================

    public function guestViewOrder(Request $request, $orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);
        return view('checkout.view_guest_order', compact('order'));
    }

    public function guestReportPaymentForm(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('checkout.report_guest_payment', compact('order'));
    }

    public function guestStorePaymentReport(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        $request->validate([
            'amount_bs' => 'required|numeric|min:0.01',
            'reference_number' => 'required|string',
            'bank_name' => 'required|string',
            'payment_date' => 'required|date',
            'proof_image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['order_id'] = $order->id;
        $data['user_id'] = $order->user_id; 
        $data['status'] = 'pending';

        if ($request->hasFile('proof_image')) {
            $data['proof_image'] = $request->file('proof_image')->store('payment_proofs', 'public');
        }

        PaymentReport::create($data);

        $viewOrderUrl = URL::signedRoute('guest.order.show', ['orderId' => $order->id]);

        return redirect($viewOrderUrl)->with('success', 'El pago ha sido reportado exitosamente. Lo validaremos a la brevedad.');
    }
}