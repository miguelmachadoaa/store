<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\PaymentReport;
use Illuminate\Support\Facades\Storage;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $ordersCount = $user->orders()->count();
        $recentOrders = $user->orders()->latest()->take(5)->get();
        $paymentsCount = PaymentReport::where('user_id', $user->id)->count();

        return view('customer.dashboard', compact('user', 'ordersCount', 'recentOrders', 'paymentsCount'));
    }

    public function orders()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);
        return view('customer.orders', compact('orders'));
    }

    public function payments()
    {
        $payments = PaymentReport::where('user_id', auth()->id())->latest()->paginate(10);
        return view('customer.payments', compact('payments'));
    }

    public function reportPaymentForm()
    {
        $orders = auth()->user()->orders()->whereIn('status', ['pendiente', 'cancelada'])->get();
        return view('customer.report-payment', compact('orders'));
    }

    public function storePaymentReport(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount_bs' => 'required|numeric|min:0.01',
            'reference_number' => 'required|string',
            'bank_name' => 'required|string',
            'payment_date' => 'required|date',
            'proof_image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['status'] = 'pending';

        if ($request->hasFile('proof_image')) {
            $data['proof_image'] = $request->file('proof_image')->store('payment_proofs', 'public');
        }

        PaymentReport::create($data);

        return redirect()->route('customer.payments')->with('success', 'Pago reportado correctamente. Será revisado pronto.');
    }

    public function profile()
    {
        $user = auth()->user();
        return view('customer.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'rif' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $user->update($request->only(['name', 'phone', 'rif', 'address']));

        return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
    }
}
