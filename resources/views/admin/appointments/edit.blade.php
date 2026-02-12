<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Cita #{{ $appointment->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-xl border border-gray-200 p-6">
                <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Customer Selection --}}
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Cliente</h3>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Usuario Registrado
                                (Opcional)</label>
                            <select name="user_id"
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                                <option value="">Seleccionar usuario...</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('user_id', $appointment->user_id) == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }} ({{ $customer->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                            <input type="text" name="customer_name"
                                value="{{ old('customer_name', $appointment->customer_name) }}" required
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                            @error('customer_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                <input type="email" name="customer_email"
                                    value="{{ old('customer_email', $appointment->customer_email) }}" required
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                                @error('customer_email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono *</label>
                                <input type="tel" name="customer_phone"
                                    value="{{ old('customer_phone', $appointment->customer_phone) }}" required
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                                @error('customer_phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Appointment Details --}}
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Detalles de la Cita</h3>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Servicio (Opcional)</label>
                            <select name="service_id"
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                                <option value="">Seleccionar servicio...</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" {{ old('service_id', $appointment->service_id) == $service->id ? 'selected' : '' }}>
                                        {{ $service->icon }} {{ $service->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha *</label>
                                <input type="date" name="appointment_date"
                                    value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}"
                                    required
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                                @error('appointment_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Hora *</label>
                                <input type="time" name="appointment_time"
                                    value="{{ old('appointment_time', $appointment->appointment_time) }}" required
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                                @error('appointment_time')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estado *</label>
                            <select name="status" required
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                                <option value="pending" {{ old('status', $appointment->status) === 'pending' ? 'selected' : '' }}>Pendiente</option>
                                <option value="confirmed" {{ old('status', $appointment->status) === 'confirmed' ? 'selected' : '' }}>Confirmada</option>
                                <option value="completed" {{ old('status', $appointment->status) === 'completed' ? 'selected' : '' }}>Completada</option>
                                <option value="cancelled" {{ old('status', $appointment->status) === 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                            </select>
                        </div>
                    </div>

                    {{-- Notes --}}
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Notas</h3>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notas del Cliente</label>
                            <textarea name="customer_notes" rows="3"
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">{{ old('customer_notes', $appointment->customer_notes) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notas Internas</label>
                            <textarea name="admin_notes" rows="3"
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">{{ old('admin_notes', $appointment->admin_notes) }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.appointments.show', $appointment) }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded">
                            Actualizar Cita
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>