<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PosCreateCustomerRequest;
use App\Http\Requests\PosCreateOrderRequest;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PosController extends Controller
{
    public function index()
    {
        return view('admin.pos.index');
    }

    public function searchCustomers(Request $request)
    {
        $query = $request->input('query');

        $customers = User::where('role', 'customer')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->orWhere('rif', 'like', "%{$query}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'email', 'phone', 'rif', 'address']);

        return response()->json($customers);
    }

    public function searchProducts(Request $request)
    {
        $query = $request->input('query');

        $products = Product::with(['tax', 'category'])
            ->where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('sku', 'like', "%{$query}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'sku', 'price', 'stock', 'image', 'tax_id', 'category_id']);

        return response()->json($products);
    }

    public function storeCustomer(PosCreateCustomerRequest $request)
    {
        $customer = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'rif' => $request->rif,
            'address' => $request->address,
            'role' => 'customer',
            'password' => bcrypt(Str::random(16)), // Contraseña temporal aleatoria
        ]);

        return response()->json([
            'success' => true,
            'customer' => $customer,
            'message' => 'Cliente creado exitosamente.',
        ]);
    }

    public function createOrder(PosCreateOrderRequest $request)
    {
        try {
            DB::beginTransaction();

            $customer = User::findOrFail($request->customer_id);
            $exchangeRate = Product::getDollarRate();

            $total = 0;
            $totalTaxableBase = 0;
            $totalTaxAmount = 0;
            $itemsToCreate = [];

            // Procesar cada producto
            foreach ($request->products as $productData) {
                $product = Product::with('tax')->findOrFail($productData['id']);
                $quantity = $productData['quantity'];

                // Verificar stock
                if ($product->stock < $quantity) {
                    DB::rollBack();

                    return response()->json([
                        'success' => false,
                        'message' => "Stock insuficiente para {$product->name}. Disponible: {$product->stock}",
                    ], 422);
                }

                $taxRate = $product->tax->rate ?? 0;
                $itemTotal = $product->price * $quantity;

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
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'tax_id' => $product->tax_id,
                    'tax_rate' => $taxRate,
                    'taxable_base' => $itemTaxableBase * $exchangeRate,
                    'tax_amount' => $itemTaxAmount * $exchangeRate,
                    'total_bs' => $itemTotal * $exchangeRate,
                    'exchange_rate' => $exchangeRate,
                ];

                // Reducir stock
                $product->decrement('stock', $quantity);
            }

            // Aplicar cupón si existe
            $discountAmount = 0;
            $couponId = null;
            if ($request->filled('coupon_code')) {
                $coupon = Coupon::where('code', $request->coupon_code)->first();
                if ($coupon && $coupon->isValid($customer, $total)) {
                    $couponId = $coupon->id;
                    $discountAmount = $coupon->calculateDiscount($total, $request->products);
                    $total -= $discountAmount;
                    $coupon->increment('used_count');
                }
            }

            // Crear la orden
            $order = Order::create([
                'user_id' => $customer->id,
                'customer_name' => $customer->name,
                'customer_email' => $customer->email,
                'customer_rif' => $customer->rif ?? '',
                'address' => $customer->address ?? '',
                'payment_method' => $request->payment_method,
                'total' => $total,
                'total_bs' => $total * $exchangeRate,
                'taxable_base' => $totalTaxableBase * $exchangeRate,
                'tax_amount' => $totalTaxAmount * $exchangeRate,
                'exchange_rate' => $exchangeRate,
                'status' => $request->status,
                'coupon_id' => $couponId,
                'discount_amount' => $discountAmount,
            ]);

            // Crear los items de la orden
            foreach ($itemsToCreate as $itemData) {
                $itemData['order_id'] = $order->id;
                OrderItem::create($itemData);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'order' => $order,
                'message' => 'Orden creada exitosamente.',
                'redirect' => route('admin.orders.show', $order->id),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al crear la orden: '.$e->getMessage(),
            ], 500);
        }
    }
}
