<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        // Si tus órdenes guardan el user_id:
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('customer.dashboard', compact('orders'));
    }
}