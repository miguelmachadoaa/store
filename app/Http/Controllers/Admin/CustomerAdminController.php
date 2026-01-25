<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;

class CustomerAdminController extends Controller
{
    public function index()
    {
        $customers = User::orderBy('id', 'desc')->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $user)
    {
        $orders = Order::where('customer_email', $user->email)->get();

        return view('admin.customers.show', compact('user', 'orders'));
    }
}