<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Órdenes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg sm:rounded-xl border border-gray-200 p-6">

                @if($orders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pago</th> {{-- ◄ Nueva columna --}}
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total (USD)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total (Bs)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($orders as $order)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">{{ $order->id }}</td>
                                        <td class="px-6 py-4">{{ $order->customer_name }}</td>
                                        <td class="px-6 py-4">{{ $order->customer_email }}</td>
                                        
                                        {{-- Celda del Método de Pago --}}
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                @if($order->paymentMethod && $order->paymentMethod->logo)
                                                    <img src="{{ asset('storage/' . $order->paymentMethod->logo) }}" 
                                                         class="h-5 w-auto object-contain max-w-[50px]" 
                                                         alt="{{ $order->payment_method }}"
                                                         title="{{ $order->payment_method }}">
                                                @else
                                                    <span class="text-xs font-medium text-gray-700 bg-gray-100 px-2 py-1 rounded">
                                                        {{ $order->payment_method ?? 'No especificado' }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 font-semibold">${{ number_format($order->total, 2) }}</td>
                                        <td class="px-6 py-4">
                                            @if($order->total_bs)
                                                Bs. {{ number_format($order->total_bs, 2) }}
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full {{ $order->status_badge }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('admin.orders.show', $order) }}"
                                                class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                                Ver Detalle
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>

                @else
                    <p class="text-gray-600">No hay órdenes registradas.</p>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>