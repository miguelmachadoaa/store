<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $date = $request->input('date');

        $orders = Order::latest()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_rif', 'like', "%{$search}%") // Usando tu columna real
                    ->orWhere('total', 'like', "%{$search}%")
                    ->orWhere('total_bs', 'like', "%{$search}%");
                });
            })
            ->when($date, function ($query, $date) {
                $query->whereDate('created_at', $date);
            })
            ->paginate(10)
            ->appends($request->all()); 

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items', 'paymentReports', 'user']);

        $whatsappUrl = null;

        if ($order->user && $order->user->phone) {
            // 1. Limpiar el número: deja solo los dígitos (elimina -, ., espacios, etc.)
            $cleanPhone = preg_replace('/[^0-9]/', '', $order->user->phone);

            // 2. Validar el código de país (58)
            if (!str_starts_with($cleanPhone, '58')) {
                // Si el número empieza por 0 (ej: 0412...), se lo quitamos antes de poner el 58
                if (str_starts_with($cleanPhone, '0')) {
                    $cleanPhone = substr($cleanPhone, 1);
                }
                $cleanPhone = '58' . $cleanPhone;
            }

            // 3. Crear el enlace directo
            $whatsappUrl = "https://wa.me/{$cleanPhone}";
        }

        return view('admin.orders.show', compact('order', 'whatsappUrl'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pendiente,pagada,enviada,cancelada'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Estado actualizado correctamente.');
    }
}