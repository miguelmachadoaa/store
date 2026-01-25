<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        return view('checkout.index', compact('cart'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'address' => 'required|string',
            'payment' => 'required|string',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        // Crear la orden
        $order = Order::create([
            'customer_name'  => $request->name,
            'customer_email' => $request->email,
            'address'        => $request->address,
            'payment_method' => $request->payment,
            'total'          => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
        ]);

        // Crear los items de la orden
        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $productId,
                'name'       => $item['name'],
                'price'      => $item['price'],
                'quantity'   => $item['quantity'],
            ]);
        }

        // Vaciar carrito
        session()->forget('cart');

        return redirect()->route('checkout.success', $order->id);
    }

    public function success($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);

        return view('checkout.success', compact('order'));
    }
}