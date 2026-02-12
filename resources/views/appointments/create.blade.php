<x-front-layout>
    @section('title', 'Agendar Cita - ' . config('app.name'))
    @section('meta_description', 'Agenda una cita con nosotros de forma rápida y sencilla.')

    {{-- Hero Section --}}
    <div class="relative bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 text-white py-20">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="relative max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">Agenda tu Cita</h1>
            <p class="text-xl md:text-2xl text-indigo-100 max-w-3xl mx-auto">
                Completa el formulario y nos pondremos en contacto contigo pronto
            </p>
        </div>
    </div>

    {{-- Booking Form --}}
    <div class="max-w-3xl mx-auto px-6 py-16">
        <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-12">
            <form action="{{ route('appointments.store') }}" method="POST" id="appointmentForm">
                @csrf

                {{-- Service Selection --}}
                @if($services->count() > 0)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Servicio (Opcional)</label>
                        <select name="service_id"
                            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                            <option value="">Seleccionar servicio...</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->icon }} {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                {{-- Date & Time --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha *</label>
                        <input type="date" name="appointment_date" value="{{ old('appointment_date') }}"
                            min="{{ date('Y-m-d') }}" required
                            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                        @error('appointment_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hora *</label>
                        <input type="time" name="appointment_time" value="{{ old('appointment_time') }}" required
                            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                        @error('appointment_time')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Customer Information --}}
                <div class="border-t pt-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4">Información de Contacto</h3>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo *</label>
                        <input type="text" name="customer_name"
                            value="{{ old('customer_name', auth()->user()->name ?? '') }}" required
                            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                        @error('customer_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" name="customer_email"
                                value="{{ old('customer_email', auth()->user()->email ?? '') }}" required
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                            @error('customer_email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono *</label>
                            <input type="tel" name="customer_phone"
                                value="{{ old('customer_phone', auth()->user()->phone ?? '') }}" required
                                placeholder="04141234567"
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                            @error('customer_phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Notes --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notas o Comentarios (Opcional)</label>
                    <textarea name="customer_notes" rows="4"
                        class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg"
                        placeholder="Cuéntanos más sobre lo que necesitas...">{{ old('customer_notes') }}</textarea>
                    @error('customer_notes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end gap-4">
                    <a href="{{ url()->previous() }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-8 rounded-lg transition">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-lg transition shadow-lg hover:shadow-xl">
                        Agendar Cita
                    </button>
                </div>
            </form>
        </div>

        {{-- Info Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
            <div class="bg-white p-6 rounded-xl shadow-md text-center">
                <div class="text-4xl mb-3">📅</div>
                <h3 class="font-bold mb-2">Flexible</h3>
                <p class="text-gray-600 text-sm">Elige la fecha y hora que mejor te convenga</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md text-center">
                <div class="text-4xl mb-3">⚡</div>
                <h3 class="font-bold mb-2">Rápido</h3>
                <p class="text-gray-600 text-sm">Confirmación inmediata por email</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md text-center">
                <div class="text-4xl mb-3">🔒</div>
                <h3 class="font-bold mb-2">Seguro</h3>
                <p class="text-gray-600 text-sm">Tus datos están protegidos</p>
            </div>
        </div>
    </div>
</x-front-layout>