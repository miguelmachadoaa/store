<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Forma de Pago: {{ $paymentMethod->name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form action="{{ route('admin.payment-methods.update', $paymentMethod) }}" method="POST" enctype="multipart/form-data">
                    @csrf 
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block font-semibold mb-1">Nombre</label>
                            <input type="text" name="name" value="{{ old('name', $paymentMethod->name) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Tipo de Pago</label>
                            <select name="type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="manual" {{ old('type', $paymentMethod->type) == 'manual' ? 'selected' : '' }}>Manual (Pago Móvil, Zelle, Transferencia, Binance)</option>
                                <option value="stripe" {{ old('type', $paymentMethod->type) == 'stripe' ? 'selected' : '' }}>Stripe Gateway</option>
                                <option value="paypal" {{ old('type', $paymentMethod->type) == 'paypal' ? 'selected' : '' }}>PayPal Gateway</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block font-semibold mb-1">Moneda</label>
                            <select name="currency" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="USD" {{ old('currency', $paymentMethod->currency) == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                <option value="BS" {{ old('currency', $paymentMethod->currency) == 'BS' ? 'selected' : '' }}>BS (Bs.)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Estado</label>
                            <select name="is_active" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="1" {{ old('is_active', $paymentMethod->is_active) ? 'selected' : '' }}>Activa</option>
                                <option value="0" {{ old('is_active', $paymentMethod->is_active) === 0 ? 'selected' : '' }}>Inactiva</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Detalle / Instrucciones</label>
                        <textarea name="description" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $paymentMethod->description) }}</textarea>
                    </div>

                    <!-- Archivos Multimedia (Logo + QR) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 rounded-md border border-gray-200">
                        <div>
                            <label class="block font-semibold mb-1 text-sm">Logo / Icono</label>
                            @if($paymentMethod->logo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $paymentMethod->logo) }}" class="h-16 w-16 object-contain border p-1 rounded bg-white">
                                </div>
                            @endif
                            <input type="file" name="logo" accept="image/*" class="w-full text-sm border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block font-semibold mb-1 text-sm">Imagen QR de Pago (Opcional)</label>
                            @if($paymentMethod->qr_code)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $paymentMethod->qr_code) }}" class="h-16 w-16 object-cover border p-1 rounded bg-white">
                                </div>
                            @endif
                            <input type="file" name="qr_code" accept="image/*" class="w-full text-sm border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <!-- Datos Bancarios / Pago (2 campos) -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <label class="block font-semibold">Datos Bancarios / Pago</label>
                            <button type="button" id="add-detail-btn" class="px-3 py-1 bg-gray-800 text-white text-xs font-semibold rounded hover:bg-gray-700">
                                + Agregar Campo
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mb-3">Modifica las etiquetas y valores para la copia rápida.</p>
                        
                        <div id="bank-details-container" class="space-y-2">
                            @php
                                $details = old('bank_details', $paymentMethod->bank_details ?? []);
                            @endphp

                            @if(!empty($details) && count($details) > 0)
                                @foreach($details as $index => $item)
                                    @php
                                        // Normaliza la información si venía en formato string previo
                                        $label = is_array($item) ? ($item['label'] ?? '') : 'Dato';
                                        $val = is_array($item) ? ($item['value'] ?? '') : $item;
                                    @endphp
                                    <div class="flex items-center gap-2 detail-row">
                                        <input type="text" name="bank_details[{{ $index }}][label]" value="{{ $label }}" placeholder="Etiqueta" class="w-1/3 rounded-md border-gray-300 text-sm focus:ring-indigo-500">
                                        <input type="text" name="bank_details[{{ $index }}][value]" value="{{ $val }}" placeholder="Valor para copiar" class="w-2/3 rounded-md border-gray-300 text-sm focus:ring-indigo-500">
                                        <button type="button" class="remove-row text-red-500 hover:text-red-700 font-bold px-2">✕</button>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex items-center gap-2 detail-row">
                                    <input type="text" name="bank_details[0][label]" value="Banco" placeholder="Etiqueta" class="w-1/3 rounded-md border-gray-300 text-sm focus:ring-indigo-500">
                                    <input type="text" name="bank_details[0][value]" value="" placeholder="Valor para copiar" class="w-2/3 rounded-md border-gray-300 text-sm focus:ring-indigo-500">
                                    <button type="button" class="remove-row text-red-500 hover:text-red-700 font-bold px-2">✕</button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('admin.payment-methods.index') }}" class="text-gray-600 hover:underline">Cancelar</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('bank-details-container');
            const addBtn = document.getElementById('add-detail-btn');
            let rowCount = container.querySelectorAll('.detail-row').length;

            addBtn.addEventListener('click', function () {
                const newRow = document.createElement('div');
                newRow.className = 'flex items-center gap-2 detail-row';
                newRow.innerHTML = `
                    <input type="text" name="bank_details[${rowCount}][label]" placeholder="Etiqueta (Ej: Titular)" class="w-1/3 rounded-md border-gray-300 text-sm focus:ring-indigo-500">
                    <input type="text" name="bank_details[${rowCount}][value]" placeholder="Valor para copiar" class="w-2/3 rounded-md border-gray-300 text-sm focus:ring-indigo-500">
                    <button type="button" class="remove-row text-red-500 hover:text-red-700 font-bold px-2">✕</button>
                `;
                container.appendChild(newRow);
                rowCount++;
            });

            container.addEventListener('click', function (e) {
                if (e.target && e.target.classList.contains('remove-row')) {
                    const row = e.target.closest('.detail-row');
                    if (container.querySelectorAll('.detail-row').length > 1) {
                        row.remove();
                    } else {
                        row.querySelectorAll('input').forEach(i => i.value = '');
                    }
                }
            });
        });
    </script>
</x-app-layout>