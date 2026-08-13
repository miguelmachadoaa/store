<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Forma de Pago: {{ $paymentMethod->name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form action="{{ route('admin.payment-methods.update', $paymentMethod) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Nombre</label>
                        <input type="text" name="name" value="{{ $paymentMethod->name }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Tipo de Pago</label>
                        <select name="type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="manual" {{ $paymentMethod->type == 'manual' ? 'selected' : '' }}>Manual (Efectivo, Transferencia, etc.)</option>
                            <option value="stripe" {{ $paymentMethod->type == 'stripe' ? 'selected' : '' }}>Stripe Gateway</option>
                            <option value="paypal" {{ $paymentMethod->type == 'paypal' ? 'selected' : '' }}>PayPal Gateway</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Moneda</label>
                        <select name="currency" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="USD" {{ (old('currency', $paymentMethod->currency ?? '') == 'USD') ? 'selected' : '' }}>USD ($)</option>
                            <option value="BS" {{ (old('currency', $paymentMethod->currency ?? '') == 'BS') ? 'selected' : '' }}>BS (Bs.)</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Detalle / Instrucciones</label>
                        <textarea name="description" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $paymentMethod->description }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Logo Actual</label>
                        @if($paymentMethod->logo)
                            <img src="{{ asset('storage/' . $paymentMethod->logo) }}" class="h-16 w-16 object-contain mb-2 border p-1 rounded">
                        @endif
                        <input type="file" name="logo" class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Estado</label>
                        <select name="is_active" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="1" {{ $paymentMethod->is_active ? 'selected' : '' }}>Activa</option>
                            <option value="0" {{ !$paymentMethod->is_active ? 'selected' : '' }}>Inactiva</option>
                        </select>
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('admin.payment-methods.index') }}" class="text-gray-600 hover:underline">Cancelar</a>
                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>