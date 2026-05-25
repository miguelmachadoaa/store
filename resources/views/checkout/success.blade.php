<x-front-layout>
    <section class="max-w-3xl mx-auto py-12 px-6 text-center">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h2 class="text-3xl font-bold text-green-600 mb-2">¡Pedido Completado Exitosamente!</h2>
        <p class="text-gray-600 mb-8">Gracias por tu compra, <span class="font-semibold text-gray-800">{{ $order->customer_name }}</span>.</p>

        <!-- Bloque de Enlaces de Control de Invitado (Bypass de Logins) -->
        <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-5 mb-8 text-left max-w-xl mx-auto">
            <h4 class="text-sm font-bold text-indigo-900 mb-2">Gestión y Seguimiento de tu Orden:</h4>
            <p class="text-xs text-indigo-700 mb-4">Utiliza los siguientes enlaces seguros para procesar tu orden en cualquier momento sin necesidad de autenticarte:</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <a href="{{ $reportPaymentUrl }}" class="flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-4 rounded-lg text-sm transition shadow-sm">
                    💳 Reportar Pago Móvil / Transf.
                </a>
                <a href="{{ $viewOrderUrl }}" class="flex items-center justify-center gap-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 font-semibold py-2.5 px-4 rounded-lg text-sm transition shadow-sm">
                    📦 Ver Estado del Pedido
                </a>
            </div>
        </div>

        <div class="bg-white shadow border border-gray-100 rounded-xl p-6 text-left">
            <h3 class="text-xl font-semibold mb-4 text-gray-800">Resumen del Pedido (#{{ $order->id }})</h3>
            <ul class="space-y-3">
                @foreach($order->items as $item)
                    <li class="flex justify-between border-b border-gray-100 pb-2">
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-800">{{ $item->name }} (x{{ $item->quantity }})</span>
                            @if($item->total_bs)
                                <span class="text-xs text-indigo-600 font-medium">Bs. {{ number_format($item->total_bs, 2) }}</span>
                            @endif
                        </div>
                        <div class="flex flex-col text-right justify-center">
                            <span class="text-sm text-gray-700">${{ number_format($item->price * $item->quantity, 2) }}</span>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="text-right mt-4 flex flex-col items-end space-y-0.5">
                @if($order->taxable_base)
                    <div class="text-xs text-gray-400">Base Imponible: ${{ number_format($order->taxable_base, 2) }}</div>
                    <div class="text-xs text-gray-400 pb-2">Impuesto (IVA): ${{ number_format($order->tax_amount, 2) }}</div>
                @endif
                <div class="text-xl font-bold text-gray-800">Total: ${{ number_format($order->total, 2) }}</div>
                @if($order->total_bs)
                    <div class="text-base text-indigo-600 font-bold">Total en Bolívares: Bs. {{ number_format($order->total_bs, 2) }}</div>
                @endif
            </div>
        </div>

        <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4 max-w-md mx-auto">
            <a href="{{ URL::temporarySignedRoute('orders.invoice', now()->addHours(24), ['orderId' => $order->id]) }}"
                class="bg-gray-800 text-white px-5 py-2.5 rounded-lg shadow hover:bg-gray-900 font-medium flex items-center justify-center gap-2 text-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Descargar Factura (PDF)
            </a>
            <a href="{{ route('home') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-5 py-2.5 rounded-lg text-sm font-medium transition">
                Volver al Inicio
            </a>
        </div>
    </section>
</x-front-layout>