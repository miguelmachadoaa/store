<x-front-layout>
    @section('title', '¡Cita Agendada! - ' . config('app.name'))

    <div class="min-h-screen flex items-center justify-center px-6 py-12 bg-gradient-to-br from-indigo-50 to-purple-50">
        <div class="max-w-2xl w-full">
            <div class="bg-white rounded-2xl shadow-2xl p-12 text-center">
                {{-- Success Icon --}}
                <div class="mb-6">
                    <div class="mx-auto w-24 h-24 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                </div>

                {{-- Success Message --}}
                <h1 class="text-4xl font-bold text-gray-900 mb-4">¡Cita Agendada!</h1>
                <p class="text-xl text-gray-600 mb-8">
                    Tu solicitud de cita ha sido recibida exitosamente
                </p>

                {{-- Appointment Details --}}
                @if(session('appointment'))
                    @php $appointment = session('appointment'); @endphp
                    <div class="bg-gray-50 rounded-xl p-6 mb-8 text-left">
                        <h3 class="font-bold text-lg mb-4 text-center">Detalles de tu Cita</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Fecha:</span>
                                <span
                                    class="font-semibold">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Hora:</span>
                                <span
                                    class="font-semibold">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</span>
                            </div>
                            @if($appointment->service)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Servicio:</span>
                                    <span class="font-semibold">{{ $appointment->service->name }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-semibold">{{ $appointment->customer_email }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Next Steps --}}
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
                    <h3 class="font-bold text-blue-900 mb-3">Próximos Pasos</h3>
                    <ul class="text-left text-blue-800 space-y-2 text-sm">
                        <li class="flex items-start gap-2">
                            <span class="text-blue-600 mt-1">✓</span>
                            <span>Recibirás un email de confirmación en breve</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-blue-600 mt-1">✓</span>
                            <span>Nuestro equipo revisará tu solicitud</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-blue-600 mt-1">✓</span>
                            <span>Te contactaremos para confirmar la cita</span>
                        </li>
                    </ul>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('home') }}"
                        class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-lg transition">
                        Volver al Inicio
                    </a>
                    @if($services ?? false)
                        <a href="{{ route('services.index') }}"
                            class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-8 rounded-lg transition">
                            Ver Servicios
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-front-layout>