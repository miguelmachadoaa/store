<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $orders = Order::where('customer_email', auth()->user()->email)->get();

        return view('customer.dashboard', compact('orders'));
    }
}
