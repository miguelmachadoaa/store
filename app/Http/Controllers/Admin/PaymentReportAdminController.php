<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Importamos el Storage para interactuar con R2

class PaymentReportAdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $reports = PaymentReport::with(['user', 'order'])
            ->latest()
            ->when($search, function ($query, $search) {
                $query->where('reference_number', 'like', "%{$search}%")
                      ->orWhere('bank_name', 'like', "%{$search}%")
                      ->orWhereHas('order', function($q) use ($search) {
                          $q->where('customer_name', 'like', "%{$search}%");
                      });
            })
            ->paginate(15)
            ->appends($request->all());

        return view('admin.payments.index', compact('reports', 'search'));
    }

    /**
     * Guarda un nuevo reporte de pago subiendo el comprobante a Cloudflare R2
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'reference_number' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Validación de la imagen
        ]);

        $data = [
            'user_id' => auth()->id(),
            'order_id' => $validated['order_id'],
            'reference_number' => $validated['reference_number'],
            'bank_name' => $validated['bank_name'],
            'amount' => $validated['amount'],
            'status' => 'pending',
        ];

        // Guardar la imagen del comprobante en Cloudflare R2 si existe
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('payments', 'r2');
        }

        PaymentReport::create($data);

        return redirect()->back()->with('success', 'Reporte de pago enviado exitosamente.');
    }

    public function updateStatus(Request $request, PaymentReport $report)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending'
        ]);

        $report->update(['status' => $request->status]);

        if ($request->status === 'approved') {
            $report->order->update(['status' => 'pagada']);
        }

        return redirect()->back()->with('success', 'Estado del pago actualizado.');
    }

    /**
     * Elimina el reporte y su comprobante asociado en Cloudflare R2
     */
    public function destroy(PaymentReport $report)
    {
        // Eliminar la imagen de Cloudflare R2 si existe antes de borrar el registro
        if ($report->image) {
            Storage::disk('r2')->delete($report->image);
        }

        $report->delete();

        return redirect()->route('admin.payments.index')
                        ->with('success', 'Reporte de pago eliminado por completo.');
    }
}