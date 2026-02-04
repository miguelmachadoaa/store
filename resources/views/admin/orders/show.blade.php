<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Orden #{{ $order->id }}
            </h2>
            <a href="{{ route('orders.invoice', $order->id) }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-700 text-sm font-bold flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Descargar Factura (BS)
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg sm:rounded-xl border border-gray-200 p-6">

                {{-- Información del cliente --}}
                <h3 class="text-lg font-bold mb-4">Información del Cliente</h3>

                <div class="grid md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p><strong>Nombre:</strong> {{ $order->customer_name }}</p>
                        <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                        @if($order->user_id)
                            <p><strong>Cliente Registrado:</strong>
                                <a href="{{ route('admin.customers.show', $order->user_id) }}"
                                    class="text-indigo-600 hover:underline">
                                    Ver Perfil de Usuario
                                </a>
                            </p>
                        @endif
                    </div>
                    <div>
                        <p><strong>Dirección:</strong> {{ $order->address }}</p>
                        <p><strong>Método de Pago:</strong> {{ ucfirst($order->payment_method) }}</p>
                    </div>
                </div>

                {{-- Items --}}
                <h3 class="text-lg font-bold mb-4">Productos</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 mb-6">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cantidad
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-indigo-50">
                                    Subtotal BS
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase bg-gray-50">
                                    Tasa
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="px-6 py-4">{{ $item->name }}</td>
                                    <td class="px-6 py-4">${{ number_format($item->price, 2) }}</td>
                                    <td class="px-6 py-4">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 font-semibold">
                                        ${{ number_format($item->price * $item->quantity, 2) }}
                                        @if($item->tax_rate > 0)
                                            <div class="text-[10px] text-gray-400">Incluye IVA
                                                ({{ number_format($item->tax_rate, 0) }}%)</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-indigo-700 bg-indigo-50">
                                        Bs. {{ number_format($item->total_bs, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 text-xs bg-gray-50">
                                        Bs. {{ number_format($item->exchange_rate, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <h3 class="text-lg font-bold mt-8 mb-4">Estado de la Orden</h3>

                <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="flex items-center gap-4">
                    @csrf

                    <select name="status" class="border rounded p-2">
                        <option value="pendiente" {{ $order->status == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="pagada" {{ $order->status == 'pagada' ? 'selected' : '' }}>Pagada</option>
                        <option value="enviada" {{ $order->status == 'enviada' ? 'selected' : '' }}>Enviada</option>
                        <option value="cancelada" {{ $order->status == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                    </select>

                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                        Actualizar Estado
                    </button>
                </form>


                {{-- Totales --}}
                <div class="mt-8 border-t pt-4">
                    <div class="flex justify-end">
                        <div class="w-full sm:w-1/2 lg:w-1/3">
                            <div class="flex justify-between py-2 border-b">
                                <span class="font-semibold text-gray-600">Total USD:</span>
                                <span class="font-bold text-xl">${{ number_format($order->total, 2) }}</span>
                            </div>

                            @if($order->taxable_base)
                                <div class="flex justify-between py-2 border-b text-sm text-gray-500">
                                    <span>Base Imponible:</span>
                                    <span>${{ number_format($order->taxable_base, 2) }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b text-sm text-gray-500">
                                    <span>Impuesto (IVA):</span>
                                    <span>${{ number_format($order->tax_amount, 2) }}</span>
                                </div>
                            @endif

                            @if($order->total_bs)
                                <div class="flex justify-between py-2 border-b bg-gray-50">
                                    <span class="font-semibold text-gray-600">Tasa de Cambio:</span>
                                    <span>Bs. {{ number_format($order->exchange_rate, 2) }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b bg-indigo-50">
                                    <span class="font-bold text-indigo-800">Total Bolívares:</span>
                                    <span class="font-bold text-xl text-indigo-800">Bs.
                                        {{ number_format($order->total_bs, 2) }}</span>
                                </div>
                                @if($order->taxable_base)
                                    <div class="flex justify-between py-2 border-b bg-indigo-50 text-xs text-indigo-600">
                                        <span>Base Imponible (BS):</span>
                                        <span>Bs. {{ number_format($order->taxable_base * $order->exchange_rate, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b bg-indigo-50 text-xs text-indigo-600">
                                        <span>Impuesto (BS):</span>
                                        <span>Bs. {{ number_format($order->tax_amount * $order->exchange_rate, 2) }}</span>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>