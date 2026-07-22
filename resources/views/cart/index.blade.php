<x-front-layout>
    <section class="max-w-4xl mx-auto py-8 px-4 sm:px-6">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-6">Tu Carrito</h2>

        @php
            $showUsd = $storeSettings->showUsd();
            $showBs = $storeSettings->showBs();
            $rate = \App\Models\Product::getDollarRate();
        @endphp

        {{-- Notificaciones de éxito o error --}}
        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(count($cart) > 0)
            {{-- Inicializamos el subtotal y los arreglos para Meta Pixel --}}
            @php 
                $subtotal = 0; 
                $pixelContentIds = [];
                $pixelContents = [];
                $pixelNumItems = 0;

                foreach($cart as $id => $item) {
                    $subtotal += $item['price'] * $item['quantity'];
                    $pixelContentIds[] = (string) $id;
                    $pixelContents[] = [
                        'id' => (string) $id,
                        'quantity' => $item['quantity'],
                        'item_price' => $item['price']
                    ];
                    $pixelNumItems += $item['quantity'];
                }
                
                // Configuración de envío
                $envioGratisMinimo = 20.00;
                $costoEnvioBase = 3.00;
                $faltaParaGratis = $envioGratisMinimo - $subtotal;
                $porcentajeProgreso = min(($subtotal / $envioGratisMinimo) * 100, 100);
                $costoEnvio = $subtotal >= $envioGratisMinimo ? 0 : $costoEnvioBase;
                
                // Descuentos y totales finales
                $discount = session('coupon.discount', 0);
                $total = max(0, $subtotal - $discount + $costoEnvio);
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                
                {{-- COLUMNA DE PRODUCTOS (2/3 de ancho en desktop, apilados en móvil) --}}
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cart as $id => $item)
                        {{-- Tarjeta de producto optimizada para móviles y pantallas táctiles --}}
                        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex flex-col sm:flex-row justify-between gap-4">
                            <div class="flex-1">
                                <span class="text-sm font-semibold text-gray-900 block">{{ $item['name'] }}</span>
                                
                                <div class="mt-1 flex items-baseline gap-2">
                                    @if($showUsd)
                                        <span class="text-xs text-gray-500">${{ number_format($item['price'], 2) }} c/u</span>
                                    @endif
                                    @if($showBs)
                                        <span class="text-[11px] text-gray-400">Bs. {{ number_format($item['price'] * $rate, 2) }}</span>
                                    @endif
                                </div>

                                {{-- Controles de cantidad cómodos para el dedo --}}
                                <form action="{{ route('cart.update', $id) }}" method="POST" class="mt-3 flex items-center gap-2">
                                    @csrf
                                    <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden bg-gray-50">
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                               class="w-12 text-center text-sm bg-transparent border-none py-1 focus:outline-none focus:ring-0">
                                    </div>
                                    <button class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-2.5 py-1.5 rounded-lg transition">
                                        Actualizar
                                    </button>
                                </form>
                            </div>

                            <div class="flex sm:flex-col justify-between items-end border-t sm:border-t-0 pt-3 sm:pt-0 border-gray-100">
                                <div class="text-right">
                                    @if($showUsd)
                                        <div class="font-bold text-gray-900">${{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                                    @endif
                                    @if($showBs)
                                        <div class="text-xs text-gray-500 font-medium">Bs. {{ number_format(($item['price'] * $item['quantity']) * $rate, 2) }}</div>
                                    @endif
                                </div>

                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="mt-2">
                                    @csrf
                                    <button class="text-red-500 hover:text-red-700 text-xs font-medium flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- COLUMNA DE RESUMEN, ENVÍOS Y PAGO --}}
                <div class="space-y-4">
                    
                    {{-- 1. Barra de Progreso de Envío Gratis --}}
                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                        @if($faltaParaGratis > 0)
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xl">🚚</span>
                                <p class="text-xs text-gray-600 font-medium leading-tight">
                                    Estás a <strong class="text-indigo-600">${{ number_format($faltaParaGratis, 2) }}</strong> de obtener <strong class="text-emerald-600">Envío Gratis</strong>.
                                    <span class="block text-[10px] text-gray-400 mt-0.5">El envío actual es de ${{ number_format($costoEnvioBase, 2) }}</span>
                                </p>
                            </div>
                        @else
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xl">🎉</span>
                                <p class="text-xs text-gray-800 font-bold leading-tight">
                                    ¡Felicidades! Tienes <span class="text-emerald-600">Envío Gratis</span> asegurado.
                                </p>
                            </div>
                        @endif

                        {{-- Línea de progreso visual --}}
                        <div class="w-full bg-gray-100 h-2.5 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500 {{ $faltaParaGratis > 0 ? 'bg-indigo-600' : 'bg-emerald-500' }}"
                                 style="width: {{ $porcentajeProgreso }}%;">
                            </div>
                        </div>
                    </div>

                    {{-- 2. Tarjeta del Resumen Financiero --}}
                    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">
                            Resumen de Compra
                        </h3>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between text-gray-500">
                                <span>Subtotal</span>
                                <span class="font-semibold text-gray-800">${{ number_format($subtotal, 2) }}</span>
                            </div>

                            {{-- Línea del Costo de Envío --}}
                            <div class="flex justify-between text-gray-500">
                                <span>Envío</span>
                                @if($costoEnvio == 0)
                                    <span class="font-bold text-emerald-600 uppercase text-[11px] bg-emerald-50 px-2 py-0.5 rounded">Gratis</span>
                                @else
                                    <span class="font-semibold text-gray-800">${{ number_format($costoEnvio, 2) }}</span>
                                @endif
                            </div>

                            @if($discount > 0)
                                <div class="flex justify-between text-emerald-600 bg-emerald-50 p-2 rounded-lg">
                                    <span class="flex items-center gap-1 text-xs">
                                        Cupón ({{ session('coupon.code') }})
                                        <form action="{{ route('cart.coupon.remove') }}" method="POST" class="inline">
                                            @csrf
                                            <button class="text-red-500 hover:text-red-700 font-bold ml-1 text-[11px]">✕</button>
                                        </form>
                                    </span>
                                    <span class="font-semibold">-${{ number_format($discount, 2) }}</span>
                                </div>
                            @endif

                            <div class="border-t border-gray-100 pt-3 flex justify-between items-baseline">
                                <span class="text-base font-bold text-gray-800">Total</span>
                                <div class="text-right">
                                    @if($showUsd)
                                        <div class="text-xl font-extrabold text-indigo-700">${{ number_format($total, 2) }}</div>
                                    @endif
                                    @if($showBs)
                                        <div class="text-xs text-gray-500 font-bold mt-0.5">Bs. {{ number_format($total * $rate, 2) }}</div>
                                        <div class="text-[10px] text-gray-400 font-normal">Ref: Bs. {{ number_format($rate, 2) }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Formulario para cupones --}}
                        <form action="{{ route('cart.coupon.apply') }}" method="POST" class="mt-5 pt-4 border-t border-gray-100 flex gap-2">
                            @csrf
                            <input type="text" name="code" placeholder="Código de cupón" required
                                   class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                            <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-xs font-bold transition">
                                Aplicar
                            </button>
                        </form>

                        {{-- Botón de Checkout principal con tracking de Meta Pixel --}}
                        <div class="mt-5">
                            <a href="{{ route('checkout.index') }}"
                               onclick="trackInitiateCheckout()"
                               class="w-full flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white py-3.5 px-4 rounded-xl shadow-md hover:shadow-lg transition font-bold text-center text-sm">
                                Proceder al Pago →
                            </a>
                        </div>
                    </div>

                    {{-- 3. Métodos de Pago Aceptados (Informativo / Genera Confianza) --}}
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 text-center">
                            Métodos de pago aceptados en el checkout
                        </p>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="bg-white border border-gray-100 rounded-lg p-2.5 flex items-center gap-2 justify-center shadow-2xs">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                <span class="text-[11px] font-semibold text-gray-600">Tarjeta de Crédito</span>
                            </div>
                            <div class="bg-white border border-gray-100 rounded-lg p-2.5 flex items-center gap-2 justify-center shadow-2xs">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                <span class="text-[11px] font-semibold text-gray-600">Pago Móvil</span>
                            </div>
                        </div>
                        <p class="text-[9px] text-gray-400 mt-3 text-center">
                            Procesado de forma segura y encriptada
                        </p>
                    </div>

                </div>
            </div>

            <script>
                function trackInitiateCheckout() {
                    if (typeof fbq !== 'undefined') {
                        fbq('track', 'InitiateCheckout', {
                            content_ids: @json($pixelContentIds),
                            contents: @json($pixelContents),
                            content_type: 'product',
                            num_items: {{ $pixelNumItems }},
                            value: {{ $total }},
                            currency: 'USD'
                        });
                    }
                }
            </script>
        @else
            {{-- Estado Vacío --}}
            <div class="text-center py-16 bg-white rounded-2xl border border-gray-100 shadow-xs">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <p class="text-gray-500 text-base mb-4">Tu carrito está vacío.</p>
                <a href="{{ route('shop.index') }}" 
                   class="inline-block bg-gray-900 text-white px-6 py-2.5 rounded-xl font-semibold text-sm hover:bg-gray-800 transition">
                    Seguir Comprando
                </a>
            </div>
        @endif
    </section>
</x-front-layout>