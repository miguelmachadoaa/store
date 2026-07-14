<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class AbandonedCartController extends Controller
{
    public function index(Request $request)
    {
        // Traemos solo carritos que tengan items y precargamos las relaciones pesadas
        $query = Cart::has('items')
            ->with(['user', 'items.product'])
            ->latest();

        // Filtro opcional por si quieres buscar por email de usuario o ID de sesión
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('session_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $carts = $query->paginate(15);

        // Pequeñas métricas rápidas para las fichas superiores
        $cards = [
            'total_abandoned' => Cart::has('items')->count(),
            'total_value' => Cart::has('items')->get()->sum('total_amount'),
        ];

        return view('admin.carts.index', compact('carts', 'cards'));
    }

    public function show(Cart $cart)
    {
        // Aseguramos cargar todo lo necesario para el detalle de la auditoría
        $cart->load(['user', 'items.product']);
        
        return view('admin.carts.show', compact('cart'));
    }
}