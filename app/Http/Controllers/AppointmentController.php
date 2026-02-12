<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function create()
    {
        $services = Service::active()->ordered()->get();

        return view('appointments.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'customer_notes' => 'nullable|string|max:1000',
        ]);

        // Add authenticated user if logged in
        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
        }

        $appointment = Appointment::create($validated);

        return redirect()->route('appointments.success')
            ->with('appointment', $appointment);
    }

    public function success()
    {
        if (! session()->has('appointment')) {
            return redirect()->route('appointments.create');
        }

        return view('appointments.success');
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        $existingAppointment = Appointment::where('appointment_date', $request->date)
            ->where('appointment_time', $request->time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        return response()->json([
            'available' => ! $existingAppointment,
        ]);
    }
}
