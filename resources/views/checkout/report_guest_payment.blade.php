<x-front-layout>
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Reportar Pago
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Registra los datos de tu transferencia o pago móvil para procesar tu pedido.
                </p>
            </div>

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">

               
                
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-6 text-white flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                    <div>
                        <p class="text-indigo-100 text-xs uppercase tracking-wider font-bold">Documento de Referencia</p>
                        <h3 class="text-xl font-bold">Orden #{{ $order->id }}</h3>
                        <p class="text-xs text-indigo-200 mt-1">Fecha de compra: {{ $order->created_at->format('d/m/Y h:i A') }}</p>
                    </div>
                    <div class="sm:text-right">
                        <p class="text-indigo-100 text-xs uppercase tracking-wider font-bold">Monto Total a Pagar</p>
                        <p class="text-3xl font-black">Bs. {{ number_format($order->total_bs, 2) }}</p>
                        @if(isset($order->total_usd))
                            <p class="text-xs text-indigo-200">Ref: ${{ number_format($order->total_usd, 2) }}</p>
                        @endif
                    </div>
                </div>


                {{-- Información de pago móvil --}}
                    <div class="mx-6 mt-6 sm:mx-8 bg-indigo-50 border border-indigo-200 rounded-2xl p-5">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-indigo-500">Datos para el pago</p>
                                <h4 class="text-sm font-bold text-indigo-900">Transfiere a esta cuenta</h4>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="bg-white rounded-xl px-4 py-3 border border-indigo-100">
                                <p class="text-xs font-semibold uppercase tracking-wide text-indigo-400 mb-1">Banco:</p>
                                <p class="text-sm font-bold text-gray-800">BNC</p>
                                <p class="text-xs text-gray-500">0191</p>
                            </div>
                            <div class="bg-white rounded-xl px-4 py-3 border border-indigo-100">
                                <p class="text-xs font-semibold uppercase tracking-wide text-indigo-400 mb-1">Cédula</p>
                                <p class="text-sm font-bold text-gray-800">V-17.985.998</p>
                                <p class="text-xs text-gray-500">Titular de la cuenta</p>
                            </div>
                            <div class="bg-white rounded-xl px-4 py-3 border border-indigo-100">
                                <p class="text-xs font-semibold uppercase tracking-wide text-indigo-400 mb-1">Teléfono</p>
                                <p class="text-sm font-bold text-gray-800">0424-3272153</p>
                                <p class="text-xs text-gray-500">Pago móvil</p>
                            </div>
                        </div>

                        <p class="text-xs text-indigo-500 mt-3 text-center">
                            Realiza la transferencia y luego completa el formulario con los datos del comprobante
                        </p>
                    </div>




                <form action="{{ route('guest.payments.store', $order->id) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="amount_bs" class="block text-sm font-semibold text-gray-700 mb-1">
                                Monto Pagado (Bs.) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Bs.</span>
                                </div>
                                <input type="number" step="0.01" name="amount_bs" id="amount_bs" 
                                    value="{{ old('amount_bs', $order->total_bs) }}"
                                    class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 @error('amount_bs') border-red-500 @enderror" 
                                    required>
                            </div>
                            @error('amount_bs')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="reference_number" class="block text-sm font-semibold text-gray-700 mb-1">
                                Número de Referencia <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="reference_number" id="reference_number" 
                                value="{{ old('reference_number') }}"
                                placeholder="Ej: 12345678"
                                class="block w-full px-3 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 @error('reference_number') border-red-500 @enderror" 
                                required>
                            @error('reference_number')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="bank_name" class="block text-sm font-semibold text-gray-700 mb-1">
                                Banco Emisor / Plataforma <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="bank_name" id="bank_name" 
                                value="{{ old('bank_name') }}"
                                placeholder="Ej: Banesco, Pago Móvil Mercantil..."
                                class="block w-full px-3 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 @error('bank_name') border-red-500 @enderror" 
                                required>
                            @error('bank_name')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="payment_date" class="block text-sm font-semibold text-gray-700 mb-1">
                                Fecha de la Transacción <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="payment_date" id="payment_date" 
                                value="{{ old('payment_date', date('Y-m-d')) }}"
                                max="{{ date('Y-m-d') }}"
                                class="block w-full px-3 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 @error('payment_date') border-red-500 @enderror" 
                                required>
                            @error('payment_date')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Comprobante de Pago <span class="text-gray-400 font-normal">(Opcional)</span>
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-indigo-400 transition">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20a4 4 0 004 4h20a4 4 0 004-4V20m-6-12l-6-6m0 0L8 8m6-6v6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="proof_image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                        <span>Sube un archivo</span>
                                        <input id="proof_image" name="proof_image" type="file" accept="image/*" class="sr-only">
                                    </label>
                                    <p class="pl-1 text-gray-500">o arrastra y suelta</p>
                                </div>
                                <p class="text-xs text-gray-400">
                                    Formatos JPG, PNG hasta 2MB
                                </p>
                            </div>
                        </div>
                        @error('proof_image')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            Validar y Enviar Reporte
                        </button>
                    </div>
                </form>

            </div>
            
            <div class="text-center mt-6 text-xs text-gray-500">
                ¿Tienes problemas con tu reporte? Contáctanos de inmediato mencionando tu código de <strong>Orden #{{ $order->id }}</strong>.
            </div>

        </div>
    </div>

    <script>
        document.getElementById('proof_image').addEventListener('change', function(e){
            let fileName = e.target.files[0] ? e.target.files[0].name : "Sube un archivo";
            e.target.closest('.space-y-1').querySelector('span').textContent = fileName;
        });
    </script>
</x-front-layout>