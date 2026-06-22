<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    public function index(Request $request)
    {
        $query = PaymentMethod::orderBy('id', 'desc');

        // Búsqueda integrada (como la tienes en tu vista)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $paymentMethods = $query->paginate(10);

        return view('admin.payment_methods.index', compact('paymentMethods'));
    }

    public function create()
    {
        return view('admin.payment_methods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'type', 'description', 'is_active');

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('payment_methods', 'public');
        }

        PaymentMethod::create($data);

        return redirect()->route('payment-methods.index')->with('success', 'Forma de pago creada con éxito.');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payment_methods.edit', compact('paymentMethod'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'type', 'description', 'is_active');

        if ($request->hasFile('logo')) {
            if ($paymentMethod->logo) {
                Storage::disk('public')->delete($paymentMethod->logo);
            }
            $data['logo'] = $request->file('logo')->store('payment_methods', 'public');
        }

        $paymentMethod->update($data);

        return redirect()->route('payment-methods.index')->with('success', 'Forma de pago actualizada.');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        if ($paymentMethod->logo) {
            Storage::disk('public')->delete($paymentMethod->logo);
        }

        $paymentMethod->delete();

        return redirect()->route('payment-methods.index')->with('success', 'Forma de pago eliminada.');
    }
}