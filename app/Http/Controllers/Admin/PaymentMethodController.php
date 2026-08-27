<?php

namespace App\Http\Controllers\Admin;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class PaymentMethodController extends Controller
{
    public function index(Request $request)
    {
        $query = PaymentMethod::orderBy('id', 'desc');

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
            'currency' => 'required|in:USD,BS',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'qr_code' => 'nullable|image|max:2048',
            'bank_details' => 'nullable|array',
        ]);

        $data = $request->only('name', 'type', 'currency', 'description', 'is_active');
        $data['is_active'] = $request->has('is_active') ? $request->is_active : true;
        
        // Filtra los pares clave/valor vacíos de los datos bancarios
        // Método store() y update()
        if ($request->has('bank_details')) {
            $data['bank_details'] = array_values(array_filter($request->bank_details, function ($item) {
                return !empty($item['label']) || !empty($item['value']);
            }));
        } else {
            $data['bank_details'] = [];
        }

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('payment_methods', 'r2');
        }

        if ($request->hasFile('qr_code')) {
            $data['qr_code'] = $request->file('qr_code')->store('payment_methods/qr', 'r2');
        }

        PaymentMethod::create($data);

        return redirect()->route('admin.payment-methods.index')->with('success', 'Forma de pago creada con éxito.');
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
        'currency' => 'required|in:USD,BS',
        'description' => 'nullable|string',
        'logo' => 'nullable|image|max:2048',
        'qr_code' => 'nullable|image|max:2048',
        'bank_details' => 'nullable|array',
    ]);

    $data = $request->only('name', 'type', 'currency', 'description', 'is_active');

    // Procesar las líneas de datos para copiar (filtrar nulos o vacíos)
   // Método store() y update()
    if ($request->has('bank_details')) {
        $data['bank_details'] = array_values(array_filter($request->bank_details, function ($item) {
            return !empty($item['label']) || !empty($item['value']);
        }));
    } else {
        $data['bank_details'] = [];
    }

    if ($request->hasFile('logo')) {
        if ($paymentMethod->logo) {
            Storage::disk('public')->delete($paymentMethod->logo);
        }
        $data['logo'] = $request->file('logo')->store('payment_methods', 'public');
    }

    if ($request->hasFile('qr_code')) {
        if ($paymentMethod->qr_code) {
            Storage::disk('public')->delete($paymentMethod->qr_code);
        }
        $data['qr_code'] = $request->file('qr_code')->store('payment_methods/qr', 'public');
    }

    $paymentMethod->update($data);

    return redirect()->route('admin.payment-methods.index')->with('success', 'Forma de pago actualizada.');
}

    public function destroy(PaymentMethod $paymentMethod)
    {
        if ($paymentMethod->logo) {
            Storage::disk('public')->delete($paymentMethod->logo);
        }

        if ($paymentMethod->qr_code) {
            Storage::disk('public')->delete($paymentMethod->qr_code);
        }

        $paymentMethod->delete();

        return redirect()->route('admin.payment-methods.index')->with('success', 'Forma de pago eliminada.');
    }
}