<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Orden #{{ $order->id }}
        </h2>
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
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


                {{-- Total --}}
                <div class="text-right text-xl font-bold">
                    Total: ${{ number_format($order->total, 2) }}
                </div>

            </div>

        </div>
    </div>
</x-app-layout>