<x-front-layout>
    <section class="max-w-7xl mx-auto py-12 px-6">
        <h2 class="text-2xl font-bold mb-6">Your Cart / Tu Carrito</h2>

        @php
            $showUsd = $storeSettings->showUsd();
            $showBs = $storeSettings->showBs();
            $rate = \App\Models\Product::getDollarRate();
        @endphp

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                {{ session('error') }}
            </div>
        @endif

        @if(count($cart) > 0)
            <div class="overflow-x-auto bg-white shadow rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php $subtotal = 0; @endphp
                        @foreach($cart as $id => $item)
                            @php $subtotal += $item['price'] * $item['quantity']; @endphp
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $item['name'] }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($showUsd)
                                        <div>${{ number_format($item['price'], 2) }}</div>
                                    @endif
                                    @if($showBs)
                                        <div class="text-xs text-gray-500">Bs. {{ number_format($item['price'] * $rate, 2) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('cart.update', $id) }}" method="POST">
                                        @csrf
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                            class="w-16 border rounded p-1">
                                        <button class="text-blue-600 ml-2 text-sm hover:underline">Update</button>
                                    </form>
                                </td>
                                <td class="px-6 py-4">
                                    @if($showUsd)
                                        <div class="font-bold">${{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                                    @endif
                                    @if($showBs)
                                        <div class="text-xs text-gray-600">Bs.
                                            {{ number_format(($item['price'] * $item['quantity']) * $rate, 2) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        <button class="text-red-600 hover:text-red-800 text-sm font-medium">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        @php
                            $discount = session('coupon.discount', 0);
                            $total = $subtotal - $discount;
                        @endphp

                        <tr class="bg-gray-50">
                            <td colspan="3" class="px-6 py-2 text-right text-gray-600">Subtotal:</td>
                            <td class="px-6 py-2">
                                ${{ number_format($subtotal, 2) }}
                            </td>
                            <td></td>
                        </tr>

                        @if($discount > 0)
                        <tr class="bg-gray-50 text-green-600">
                            <td colspan="3" class="px-6 py-2 text-right">
                                Descuento ({{ session('coupon.code') }}):
                                <form action="{{ route('cart.coupon.remove') }}" method="POST" class="inline ml-1">
                                    @csrf
                                    <button class="text-red-500 text-xs hover:underline">Eliminar</button>
                                </form>
                            </td>
                            <td class="px-6 py-2 font-medium">
                                -${{ number_format($discount, 2) }}
                            </td>
                            <td></td>
                        </tr>
                        @endif

                        <tr class="font-bold bg-gray-50 border-t-2">
                            <td colspan="3" class="px-6 py-4 text-right">Total:</td>
                            <td class="px-6 py-4">
                                @if($showUsd)
                                    <div class="text-lg text-indigo-700">${{ number_format($total, 2) }}</div>
                                @endif
                                @if($showBs)
                                    <div class="text-sm text-gray-700">Bs. {{ number_format($total * $rate, 2) }}</div>
                                    <div class="text-xs text-gray-500 mt-1 font-normal">Tasa: Bs. {{ number_format($rate, 2) }}
                                    </div>
                                @endif
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-start mt-6 gap-4">
                <form action="{{ route('cart.coupon.apply') }}" method="POST" class="flex gap-2 w-full md:w-auto">
                    @csrf
                    <input type="text" name="code" placeholder="Código de cupón" required
                           class="border rounded px-4 py-2 w-full md:w-48 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded text-sm hover:bg-gray-900 transition font-semibold">
                        Aplicar
                    </button>
                </form>

                <div class="w-full md:w-auto text-right">
                    <a href="{{ route('checkout.index') }}"
                        class="inline-block bg-indigo-600 text-white px-8 py-3 rounded-lg shadow-md hover:bg-indigo-700 transition font-bold transform hover:-translate-y-0.5">
                        Proceed to Checkout / Proceder al Pago
                    </a>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">Your cart is empty.</p>
                <a href="{{ route('shop.index') }}" class="mt-4 inline-block text-indigo-600 hover:underline">
                    Back to Shop
                </a>
            </div>
        @endif
    </section>
</x-front-layout>