<x-front-layout>
    <section class="max-w-5xl mx-auto py-8 px-4 sm:px-6">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
            Tu Carrito 
            @if(count($cart) > 0)
                <span class="text-xs font-semibold bg-gray-100 text-gray-600 px-2.5 py-0.5 rounded-full">
                    {{ count($cart) }} {{ count($cart) == 1 ? 'producto' : 'productos' }}
                </span>
            @endif
        </h1>

        @php
            $showUsd = $storeSettings->showUsd();
            $showBs = $storeSettings->showBs();
            $rate = \App\Models\Product::getDollarRate();
        @endphp

        {{-- Notificaciones --}}
        @if(session('success'))
            <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-500 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 10-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(count($cart) > 0)
            @php 
                $subtotal = $cartTotals['subtotal'];
                $autoDiscount = $cartTotals['auto_discount'];
                $couponDiscount = $cartTotals['coupon_discount'];
                $costoEnvio = $cartTotals['costo_envio'];
                $costoEnvioBase = $cartTotals['costo_envio_base'];
                $faltaParaGratis = $cartTotals['falta_para_gratis'];
                $porcentajeProgreso = min(100, max(0, $cartTotals['porcentaje_progreso']));
                $total = $cartTotals['total'];

                $pixelContentIds = [];
                $pixelContents = [];
                $pixelNumItems = 0;

                foreach($cart as $id => $item) {
                    $pixelContentIds[] = (string) $id;
                    $pixelContents[] = [
                        'id' => (string) $id,
                        'quantity' => $item['quantity'],
                        'item_price' => $item['price']
                    ];
                    $pixelNumItems += $item['quantity'];
                }
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                
                {{-- COLUMNA DE PRODUCTOS --}}
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cart as $id => $item)
                        <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 transition hover:border-gray-300">
                            
                            {{-- Imagen + Info del Producto --}}
                            <div class="flex items-center gap-4 flex-1">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-50 rounded-xl overflow-hidden border border-gray-100 shrink-0">
                                    <img src="{{ Storage::disk('r2')->url($item['image']) }}" 
                                         alt="{{ $item['name'] }}" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm font-semibold text-gray-900 leading-snug line-clamp-2">{{ $item['name'] }}</h3>
                                    
                                    <div class="mt-1 flex items-baseline gap-2">
                                        @if($showUsd)
                                            <span class="text-xs font-medium text-gray-600">${{ number_format($item['price'], 2) }} c/u</span>
                                        @endif
                                        @if($showBs)
                                            <span class="text-[11px] text-gray-400">Bs. {{ number_format($item['price'] * $rate, 2) }}</span>
                                        @endif
                                    </div>

                                    {{-- Selector de Cantidad UX sin botón Actualizar --}}
                                    <form id="update-form-{{ $id }}" action="{{ route('cart.update', $id) }}" method="POST" class="mt-3 inline-flex items-center">
                                        @csrf
                                        <div class="flex items-center border border-gray-300 rounded-lg bg-gray-50 overflow-hidden shadow-xs">
                                            <button type="button" 
                                                    onclick="decrementQty('qty-{{ $id }}', 'update-form-{{ $id }}')"
                                                    class="w-7 h-7 flex items-center justify-center text-gray-600 hover:bg-gray-200 hover:text-gray-900 transition text-xs font-bold">
                                                &#8722;
                                            </button>
                                            <input type="number" 
                                                   id="qty-{{ $id }}"
                                                   name="quantity" 
                                                   value="{{ $item['quantity'] }}" 
                                                   min="1"
                                                   onchange="document.getElementById('update-form-{{ $id }}').submit()"
                                                   class="w-10 text-center text-xs font-bold text-gray-800 bg-transparent border-none p-0 focus:outline-none focus:ring-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                            <button type="button" 
                                                    onclick="incrementQty('qty-{{ $id }}', 'update-form-{{ $id }}')"
                                                    class="w-7 h-7 flex items-center justify-center text-gray-600 hover:bg-gray-200 hover:text-gray-900 transition text-xs font-bold">
                                                &#43;
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- Subtotal por ítem + Botón Eliminar --}}
                            <div class="flex sm:flex-col justify-between items-end w-full sm:w-auto border-t sm:border-t-0 pt-3 sm:pt-0 border-gray-100">
                                <div class="text-right">
                                    @if($showUsd)
                                        <div class="font-bold text-gray-900 text-base">${{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                                    @endif
                                    @if($showBs)
                                        <div class="text-xs text-gray-500 font-medium">Bs. {{ number_format(($item['price'] * $item['quantity']) * $rate, 2) }}</div>
                                    @endif
                                </div>

                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="mt-2">
                                    @csrf
                                    <button class="text-gray-400 hover:text-rose-600 text-xs font-medium flex items-center gap-1 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        <span>Eliminar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- COLUMNA DE RESUMEN --}}
                <div class="space-y-4">
                    
                    {{-- 1. Barra de Progreso de Envío Gratis --}}
                    <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-xs">
                        @if($faltaParaGratis > 0)
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xl">🚚</span>
                                <p class="text-xs text-gray-600 font-medium leading-tight">
                                    Te faltan <strong class="text-indigo-600">${{ number_format($faltaParaGratis, 2) }}</strong> para obtener <strong class="text-emerald-600">Envío Gratis</strong>.
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

                        <div class="w-full bg-gray-100 h-2.5 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500 {{ $faltaParaGratis > 0 ? 'bg-indigo-600' : 'bg-emerald-500' }}"
                                 style="width: {{ $porcentajeProgreso }}%;">
                            </div>
                        </div>
                    </div>

                    {{-- 2. Tarjeta del Resumen Financiero --}}
                    <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs">
                        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">
                            Resumen de Compra
                        </h2>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span class="font-semibold text-gray-900">${{ number_format($subtotal, 2) }}</span>
                            </div>

                            {{-- Descuento Automático por Volumen --}}
                            @if($autoDiscount['discount_amount'] > 0)
                                <div class="flex justify-between text-emerald-700 bg-emerald-50 p-2.5 rounded-xl border border-emerald-100">
                                    <span class="flex items-center gap-1.5 text-xs font-semibold">
                                        ✨ {{ $autoDiscount['label'] }}
                                    </span>
                                    <span class="font-bold">-${{ number_format($autoDiscount['discount_amount'], 2) }}</span>
                                </div>
                            @endif

                            {{-- Envío --}}
                            <div class="flex justify-between text-gray-600">
                                <span>Envío</span>
                                @if($costoEnvio == 0)
                                    <span class="font-bold text-emerald-600 uppercase text-[11px] bg-emerald-50 px-2 py-0.5 rounded-md">Gratis</span>
                                @else
                                    <span class="text-xs text-gray-500 font-medium">3$ a Nivel Nacional</span>
                                @endif
                            </div>

                            {{-- Cupón Manual Aplicado --}}
                            @if($couponDiscount > 0)
                                <div class="flex justify-between text-indigo-600 bg-indigo-50 p-2.5 rounded-xl border border-indigo-100">
                                    <span class="flex items-center gap-1 text-xs font-semibold">
                                        Cupón ({{ session('coupon.code') }})
                                        <form action="{{ route('cart.coupon.remove') }}" method="POST" class="inline">
                                            @csrf
                                            <button class="text-rose-500 hover:text-rose-700 font-bold ml-1 text-xs" title="Remover cupón">✕</button>
                                        </form>
                                    </span>
                                    <span class="font-bold">-${{ number_format($couponDiscount, 2) }}</span>
                                </div>
                            @endif

                            <div class="border-t border-gray-100 pt-3 flex justify-between items-baseline">
                                <span class="text-base font-bold text-gray-900">Total</span>
                                <div class="text-right">
                                    @if($showUsd)
                                        <div class="text-xl font-extrabold text-indigo-600">${{ number_format($total, 2) }}</div>
                                    @endif
                                    @if($showBs)
                                        <div class="text-xs text-gray-500 font-bold mt-0.5">Bs. {{ number_format($total * $rate, 2) }}</div>
                                        <div class="text-[10px] text-gray-400 font-normal">Tasa Ref: Bs. {{ number_format($rate, 2) }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Accordion Desplegable para Cupón --}}
                        <div x-data="{ open: false }" class="mt-4 pt-3 border-t border-gray-100">
                            <button @click="open = !open" type="button" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium flex items-center justify-between w-full">
                                <span>¿Tienes un código de descuento?</span>
                                <span x-text="open ? '−' : '+'" class="font-bold text-sm"></span>
                            </button>
                            <form x-show="open" x-cloak action="{{ route('cart.coupon.apply') }}" method="POST" class="mt-3 flex gap-2">
                                @csrf
                                <input type="text" name="code" placeholder="Ingresa tu código" required
                                       class="flex-1 border border-gray-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none">
                                <button type="submit" class="bg-gray-900 hover:bg-black text-white px-3.5 py-2 rounded-xl text-xs font-bold transition">
                                    Aplicar
                                </button>
                            </form>
                        </div>

                        {{-- Botón de Acción Principal --}}
                        <div class="mt-5">
                            <a href="{{ route('checkout.index') }}"
                               onclick="trackInitiateCheckout()"
                               class="w-full flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white py-3.5 px-4 rounded-xl shadow-sm hover:shadow-md transition font-bold text-center text-sm">
                                <span>Proceder al Pago</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>

                        {{-- Trust Signals / Métodos de Pago --}}
                        <div class="mt-6 pt-4 border-t border-gray-100 space-y-3">
                            <p class="text-[11px] font-semibold text-gray-400 text-center uppercase tracking-wider">Métodos de pago aceptados</p>
                            <div class="flex items-center justify-center gap-2 flex-wrap opacity-75">
                                <span class="text-[11px] font-bold text-gray-600 bg-gray-100 px-2 py-1 rounded">PagoMóvil</span>
                                <span class="text-[11px] font-bold text-gray-600 bg-gray-100 px-2 py-1 rounded">Transferencia</span>
                                <span class="text-[11px] font-bold text-gray-600 bg-gray-100 px-2 py-1 rounded">Zinli</span>
                            </div>
                            <div class="flex items-center justify-center gap-1 text-[11px] text-gray-400 mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                                <span>Pago 100% cifrado y seguro</span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <script>
                function incrementQty(inputId, formId) {
                    const input = document.getElementById(inputId);
                    input.value = parseInt(input.value || 0) + 1;
                    document.getElementById(formId).submit();
                }

                function decrementQty(inputId, formId) {
                    const input = document.getElementById(inputId);
                    if (parseInt(input.value) > 1) {
                        input.value = parseInt(input.value) - 1;
                        document.getElementById(formId).submit();
                    }
                }

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
            <div class="text-center py-16 bg-white rounded-2xl border border-gray-200 shadow-xs max-w-md mx-auto">
                <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                    🛒
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Tu carrito está vacío</h3>
                <p class="text-gray-500 text-sm mb-6">Parece que aún no has agregado ninguna joya o pulsera.</p>
                <a href="{{ route('shop.index') }}" 
                   class="inline-flex items-center gap-2 bg-indigo-600 text-white px-6 py-3 rounded-xl font-bold text-sm hover:bg-indigo-700 transition shadow-sm">
                    Descubrir Catálogo
                </a>
            </div>
        @endif
    </section>
</x-front-layout>