<x-front-layout>
    <section class="max-w-5xl mx-auto py-12 px-6">
        <h2 class="text-2xl font-semibold mb-8 text-gray-800">Finalizar pedido</h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

            {{-- COLUMNA IZQUIERDA: Resumen del pedido --}}
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-4 pb-3 border-b border-gray-100">
                    Resumen del pedido
                </h3>

                @php
                    $subtotal = 0;
                    $rate = \App\Models\Product::getDollarRate();
                    $showBs = $storeSettings->showBs();
                @endphp

                <ul class="divide-y divide-gray-100">
                    @foreach ($cart as $id => $item)
                        @php $subtotal += $item['price'] * $item['quantity']; @endphp
                        <li class="flex justify-between items-start py-3">
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $item['name'] }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">x{{ $item['quantity'] }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-800">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                @if ($showBs)
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        Bs. {{ number_format($item['price'] * $item['quantity'] * $rate, 2) }}
                                    </p>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>

                @php
                    $discount = session('coupon.discount', 0);
                    
                    // Lógica de envío: gratis a partir de $20, sino $3
                    $shippingCost = ($subtotal >= 20) ? 0 : 3; 
                    
                    $total = $subtotal - $discount + $shippingCost;
                @endphp

                <div class="mt-4 pt-4 border-t border-gray-100 space-y-1.5">
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Subtotal</span>
                        <span class="font-medium text-gray-800">${{ number_format($subtotal, 2) }}</span>
                    </div>

                    @if ($discount > 0)
                        <div class="flex justify-between text-sm text-emerald-600">
                            <span class="flex items-center gap-1">
                                Descuento ({{ session('coupon.code') }})
                                <form action="{{ route('cart.coupon.remove') }}" method="POST" class="inline">
                                    @csrf
                                    <button class="text-red-400 text-xs hover:underline ml-1">Eliminar</button>
                                </form>
                            </span>
                            <span class="font-medium">-${{ number_format($discount, 2) }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Envío (MRW / Zoom)</span>
                        <span class="font-medium {{ $shippingCost == 0 ? 'text-emerald-600' : 'text-gray-800' }}">
                            {{ $shippingCost == 0 ? 'Gratis' : '$' . number_format($shippingCost, 2) }}
                        </span>
                    </div>
                </div>

                <div class="flex justify-between items-end mt-4 pt-4 border-t border-gray-200">
                    <span class="text-base font-semibold text-gray-800">Total</span>
                    <div class="text-right">
                        <p class="text-xl font-semibold text-indigo-700">${{ number_format($total, 2) }}</p>
                        @if ($showBs)
                            <p class="text-xs text-gray-400 mt-0.5">Bs. {{ number_format($total * $rate, 2) }}</p>
                            <p class="text-xs text-gray-300 mt-0.5">Tasa: Bs. {{ number_format($rate, 2) }}</p>
                        @endif
                    </div>
                </div>

                {{-- Cupón --}}
                <div class="mt-5 pt-5 border-t border-gray-100">
                    @if (session('success'))
                        <p class="text-xs text-emerald-600 mb-2 font-medium">{{ session('success') }}</p>
                    @endif
                    @if (session('error'))
                        <p class="text-xs text-red-500 mb-2 font-medium">{{ session('error') }}</p>
                    @endif
                    <p class="text-xs text-gray-400 mb-2">Código de cupón</p>
                    <form action="{{ route('cart.coupon.apply') }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="text" name="code" placeholder="Ej: PROMO10" required
                            class="flex-1 text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-1 focus:ring-indigo-400">
                        <button type="submit"
                            class="text-sm px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition">
                            Aplicar
                        </button>
                    </form>
                </div>
            </div>

            {{-- COLUMNA DERECHA: Formulario --}}
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-4 pb-3 border-b border-gray-100">
                    Datos de envío y pago
                </h3>

                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf

                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-3">Datos personales</p>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-500 mb-1">Nombre completo</label>
                        @if(auth()->check())
                            <input type="text" value="{{ $user->name }}" readonly
                                class="w-full border border-gray-200 rounded-lg p-2.5 text-sm bg-gray-50 text-gray-400 focus:outline-none">
                        @else
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Juan Pérez"
                                class="w-full border rounded-lg p-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-400 @error('name') border-red-400 focus:ring-red-400 @else border-gray-200 @enderror">
                            @error('name')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-500 mb-1">Correo electrónico</label>
                        @if(auth()->check())
                            <input type="email" value="{{ $user->email }}" readonly
                                class="w-full border border-gray-200 rounded-lg p-2.5 text-sm bg-gray-50 text-gray-400 focus:outline-none">
                        @else
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="juan@gmail.com"
                                class="w-full border rounded-lg p-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-400 @error('email') border-red-400 focus:ring-red-400 @else border-gray-200 @enderror">
                            @error('email')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm text-gray-500 mb-1">C.I. / RIF</label>
                            <input type="text" name="rif" value="{{ old('rif', $user?->rif) }}" required
                                placeholder="V-12345678-0"
                                class="w-full border rounded-lg p-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-400 @error('rif') border-red-400 focus:ring-red-400 @else border-gray-200 @enderror">
                            @error('rif')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm text-gray-500 mb-1">Teléfono</label>
                            <input type="text" name="phone" value="{{ old('phone', $user?->phone) }}" required
                                placeholder="0424-5478154"
                                class="w-full border rounded-lg p-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-400 @error('phone') border-red-400 focus:ring-red-400 @else border-gray-200 @enderror">
                            @error('phone')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm text-gray-500 mb-1">Dirección de la Oficina de Envío</label>
                        <textarea name="address" rows="3" required placeholder="Especificar si es oficina MRW o Zoom, ciudad y estado..."
                            class="w-full border rounded-lg p-2.5 text-sm resize-none focus:outline-none focus:ring-1 focus:ring-indigo-400 @error('address') border-red-400 focus:ring-red-400 @else border-gray-200 @enderror">{{ old('address', $user?->address) }}</textarea>
                        @error('address')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr class="border-gray-100 mb-5">

                    {{-- Agencia de Envío --}}
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-3">Agencia de envío</p>

                    <div class="grid grid-cols-2 gap-3 mb-5">
                        @foreach (['mrw' => 'Retiro MRW', 'zoom' => 'Retiro Zoom'] as $value => $label)
                            <label class="cursor-pointer">
                                <input type="radio" name="shipping_method" value="{{ $value }}" class="sr-only peer"
                                    {{ old('shipping_method', 'mrw') === $value ? 'checked' : '' }}>
                                <div class="text-center text-sm py-3 border border-gray-200 rounded-lg font-medium
                                    peer-checked:border-indigo-500 peer-checked:text-indigo-600 peer-checked:bg-indigo-50/50
                                    text-gray-500 hover:border-gray-300 transition">
                                    {{ $label }}
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <hr class="border-gray-100 mb-5">

                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-3">Método de pago</p>

                    <div class="grid grid-cols-2 gap-3 mb-6">
                        @foreach (['card' => 'Tarjeta', 'transfer' => 'Pago Móvil'] as $value => $label)
                            <label class="cursor-pointer">
                                <input type="radio" name="payment" value="{{ $value }}" class="sr-only peer"
                                    {{ old('payment', 'card') === $value ? 'checked' : '' }}>
                                <div class="text-center text-sm py-3 border border-gray-200 rounded-lg font-medium
                                    peer-checked:border-indigo-500 peer-checked:text-indigo-600 peer-checked:bg-indigo-50/50
                                    text-gray-500 hover:border-gray-300 transition">
                                    {{ $label }}
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition text-base shadow-sm hover:shadow active:transform active:scale-[0.99]">
                        Confirmar pedido →
                    </button>

                    <p class="text-center text-xs text-gray-300 mt-3 flex items-center justify-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Pago seguro y encriptado
                    </p>
                </form>
            </div>

        </div>
    </section>
</x-front-layout>