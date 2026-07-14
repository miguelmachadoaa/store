<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request; // Asegúrate de tener esta línea

class CustomerAdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $customers = User::orderBy('id', 'desc')
            ->when($search, function($query, $search) {
                return $query->where('name', 'LIKE', "%{$search}%")
                             ->orWhere('email', 'LIKE', "%{$search}%")
                             ->orWhere('phone', 'LIKE', "%{$search}%")
                             ->orWhere('rif', 'LIKE', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString(); // Esto mantiene el término de búsqueda al cambiar de página

        return view('admin.customers.index', compact('customers', 'search'));
    }

    public function show(User $user)
    {
        $user->load('favorites');
        $orders = Order::where('user_id', $user->id)->get();

        $whatsappUrl = null;

        if ($user->phone) {
            $cleanPhone = preg_replace('/[^0-9]/', '', $user->phone);

            if (!str_starts_with($cleanPhone, '58')) {
                if (str_starts_with($cleanPhone, '0')) {
                    $cleanPhone = substr($cleanPhone, 1);
                }
                $cleanPhone = '58' . $cleanPhone;
            }

            $whatsappUrl = "https://wa.me/{$cleanPhone}";
        }

        return view('admin.customers.show', compact('user', 'orders', 'whatsappUrl'));
    }
}