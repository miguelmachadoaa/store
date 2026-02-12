<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalle de Cita #{{ $appointment->id }}
            </h2>
            <a href="{{ route('admin.appointments.index') }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main Info --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Appointment Details --}}
                    <div class="bg-white shadow-lg rounded-xl p-6">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2">Información de la Cita</h3>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Fecha</p>
                                <p class="font-semibold text-lg">{{ $appointment->formatted_date }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Hora</p>
                                <p class="font-semibold text-lg">{{ $appointment->formatted_time }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Estado</p>
                                <div class="mt-1">{!! $appointment->status_badge !!}</div>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Servicio</p>
                                <p class="font-semibold">{{ $appointment->service?->name ?? 'No especificado' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Customer Info --}}
                    <div class="bg-white shadow-lg rounded-xl p-6">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2">Información del Cliente</h3>

                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-600">Nombre</p>
                                <p class="font-semibold">{{ $appointment->customer_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="font-semibold">
                                    <a href="mailto:{{ $appointment->customer_email }}"
                                        class="text-indigo-600 hover:underline">
                                        {{ $appointment->customer_email }}
                                    </a>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Teléfono</p>
                                <p class="font-semibold">
                                    <a href="tel:{{ $appointment->customer_phone }}"
                                        class="text-indigo-600 hover:underline">
                                        {{ $appointment->customer_phone }}
                                    </a>
                                </p>
                            </div>
                            @if($appointment->user)
                                <div>
                                    <p class="text-sm text-gray-600">Usuario Registrado</p>
                                    <p class="font-semibold">
                                        <a href="{{ route('admin.customers.show', $appointment->user) }}"
                                            class="text-indigo-600 hover:underline">
                                            Ver perfil
                                        </a>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Notes --}}
                    <div class="bg-white shadow-lg rounded-xl p-6">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2">Notas</h3>

                        @if($appointment->customer_notes)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-1">Notas del Cliente:</p>
                                <p class="bg-gray-50 p-3 rounded">{{ $appointment->customer_notes }}</p>
                            </div>
                        @endif

                        <div>
                            <p class="text-sm text-gray-600 mb-1">Notas Internas:</p>
                            <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="user_id" value="{{ $appointment->user_id }}">
                                <input type="hidden" name="service_id" value="{{ $appointment->service_id }}">
                                <input type="hidden" name="customer_name" value="{{ $appointment->customer_name }}">
                                <input type="hidden" name="customer_email" value="{{ $appointment->customer_email }}">
                                <input type="hidden" name="customer_phone" value="{{ $appointment->customer_phone }}">
                                <input type="hidden" name="appointment_date"
                                    value="{{ $appointment->appointment_date->format('Y-m-d') }}">
                                <input type="hidden" name="appointment_time"
                                    value="{{ $appointment->appointment_time }}">
                                <input type="hidden" name="status" value="{{ $appointment->status }}">
                                <input type="hidden" name="customer_notes" value="{{ $appointment->customer_notes }}">

                                <textarea name="admin_notes" rows="3"
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg mb-2"
                                    placeholder="Agregar notas internas...">{{ $appointment->admin_notes }}</textarea>
                                <button type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                                    Guardar Notas
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Sidebar Actions --}}
                <div class="space-y-6">
                    {{-- Quick Actions --}}
                    <div class="bg-white shadow-lg rounded-xl p-6">
                        <h3 class="text-lg font-bold mb-4">Acciones</h3>

                        <div class="space-y-2">
                            @if($appointment->status === 'pending')
                                <form action="{{ route('admin.appointments.status', $appointment) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit"
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Confirmar Cita
                                    </button>
                                </form>
                            @endif

                            @if(in_array($appointment->status, ['pending', 'confirmed']))
                                <form action="{{ route('admin.appointments.status', $appointment) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit"
                                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Marcar Completada
                                    </button>
                                </form>

                                <form action="{{ route('admin.appointments.status', $appointment) }}" method="POST"
                                    onsubmit="return confirm('¿Estás seguro de cancelar esta cita?');">
                                    @csrf
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Cancelar Cita
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('admin.appointments.edit', $appointment) }}"
                                class="block w-full bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded text-center">
                                Editar Cita
                            </a>

                            <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST"
                                onsubmit="return confirm('¿Estás seguro de eliminar esta cita?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Eliminar Cita
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Status History --}}
                    <div class="bg-white shadow-lg rounded-xl p-6">
                        <h3 class="text-lg font-bold mb-4">Historial</h3>

                        <div class="space-y-3 text-sm">
                            <div>
                                <p class="text-gray-600">Creada:</p>
                                <p class="font-semibold">{{ $appointment->created_at->format('d/m/Y h:i A') }}</p>
                            </div>
                            @if($appointment->confirmed_at)
                                <div>
                                    <p class="text-gray-600">Confirmada:</p>
                                    <p class="font-semibold">{{ $appointment->confirmed_at->format('d/m/Y h:i A') }}</p>
                                </div>
                            @endif
                            @if($appointment->completed_at)
                                <div>
                                    <p class="text-gray-600">Completada:</p>
                                    <p class="font-semibold">{{ $appointment->completed_at->format('d/m/Y h:i A') }}</p>
                                </div>
                            @endif
                            @if($appointment->cancelled_at)
                                <div>
                                    <p class="text-gray-600">Cancelada:</p>
                                    <p class="font-semibold">{{ $appointment->cancelled_at->format('d/m/Y h:i A') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>