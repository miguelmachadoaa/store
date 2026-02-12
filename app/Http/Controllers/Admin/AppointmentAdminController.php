<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['user', 'service']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        // Search by customer name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(20);

        return view('admin.appointments.index', compact('appointments'));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['user', 'service']);

        return view('admin.appointments.show', compact('appointment'));
    }

    public function create()
    {
        $services = Service::active()->ordered()->get();
        $customers = User::where('role', 'customer')->orderBy('name')->get();

        return view('admin.appointments.create', compact('services', 'customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'service_id' => 'nullable|exists:services,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'customer_notes' => 'nullable|string',
            'admin_notes' => 'nullable|string',
        ]);

        // Set status timestamps
        if ($validated['status'] === 'confirmed') {
            $validated['confirmed_at'] = now();
        } elseif ($validated['status'] === 'completed') {
            $validated['completed_at'] = now();
        } elseif ($validated['status'] === 'cancelled') {
            $validated['cancelled_at'] = now();
        }

        $appointment = Appointment::create($validated);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Cita creada exitosamente.');
    }

    public function edit(Appointment $appointment)
    {
        $services = Service::active()->ordered()->get();
        $customers = User::where('role', 'customer')->orderBy('name')->get();

        return view('admin.appointments.edit', compact('appointment', 'services', 'customers'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'service_id' => 'nullable|exists:services,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'customer_notes' => 'nullable|string',
            'admin_notes' => 'nullable|string',
        ]);

        // Update status timestamps if status changed
        if ($validated['status'] !== $appointment->status) {
            if ($validated['status'] === 'confirmed') {
                $validated['confirmed_at'] = now();
            } elseif ($validated['status'] === 'completed') {
                $validated['completed_at'] = now();
            } elseif ($validated['status'] === 'cancelled') {
                $validated['cancelled_at'] = now();
            }
        }

        $appointment->update($validated);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Cita actualizada exitosamente.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Cita eliminada exitosamente.');
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        switch ($request->status) {
            case 'confirmed':
                $appointment->confirm();
                break;
            case 'completed':
                $appointment->complete();
                break;
            case 'cancelled':
                $appointment->cancel();
                break;
            default:
                $appointment->update(['status' => $request->status]);
        }

        return back()->with('success', 'Estado actualizado exitosamente.');
    }
}
