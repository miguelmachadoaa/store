<x-customer-layout>
    <div class="bg-white shadow rounded-lg p-6 border border-gray-100 max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Reportar Pago</h2>

        <form action="{{ route('customer.payments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block font-semibold mb-1">Seleccionar Orden</label>
                <select name="order_id" class="w-full border rounded-lg p-2 @error('order_id') border-red-500 @enderror"
                    required>
                    <option value="">Seleccione una orden pendiente</option>
                    @foreach($orders as $order)
                        <option value="{{ $order->id }}" {{ old('order_id') == $order->id ? 'selected' : '' }}>
                            Orden #{{ $order->id }} - Bs. {{ number_format($order->total_bs, 2) }}
                            ({{ $order->created_at->format('d/m/Y') }})
                        </option>
                    @endforeach
                </select>
                @error('order_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-semibold mb-1">Monto Pagado (BS)</label>
                    <input type="number" step="0.01" name="amount_bs" value="{{ old('amount_bs') }}"
                        class="w-full border rounded-lg p-2 @error('amount_bs') border-red-500 @enderror" required>
                    @error('amount_bs')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block font-semibold mb-1">Número de Referencia</label>
                    <input type="text" name="reference_number" value="{{ old('reference_number') }}"
                        class="w-full border rounded-lg p-2 @error('reference_number') border-red-500 @enderror"
                        required>
                    @error('reference_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-semibold mb-1">Banco Emisor</label>
                    <input type="text" name="bank_name" value="{{ old('bank_name') }}"
                        class="w-full border rounded-lg p-2 @error('bank_name') border-red-500 @enderror" required
                        placeholder="Ej: Banesco, Mercantil...">
                    @error('bank_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block font-semibold mb-1">Fecha del Pago</label>
                    <input type="date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}"
                        class="w-full border rounded-lg p-2 @error('payment_date') border-red-500 @enderror" required>
                    @error('payment_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="block font-semibold mb-1">Comprobante (Imagen - Opcional)</label>
                <input type="file" name="proof_image" accept="image/*"
                    class="w-full border rounded-lg p-2 @error('proof_image') border-red-500 @enderror">
                @error('proof_image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-400 text-xs mt-1 italic">Formatos permitidos: JPG, PNG. Máximo 2MB.</p>
            </div>

            <div class="text-right">
                <button type="submit"
                    class="bg-indigo-600 text-white px-8 py-3 rounded-xl hover:bg-indigo-700 font-bold transition shadow-lg">
                    Enviar Reporte de Pago
                </button>
            </div>
        </form>
    </div>
</x-customer-layout>