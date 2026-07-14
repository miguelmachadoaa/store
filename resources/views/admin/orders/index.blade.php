<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Órdenes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Formulario de Búsqueda -->
            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-200 p-6 mb-6">
                <form action="{{ route('admin.orders.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar cliente, tlf, cédula o monto</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                            placeholder="Ej: Juan Pérez, 0414..., 123456"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>

                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Filtrar por Fecha</label>
                        <input type="date" name="date" id="date" value="{{ request('date') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md text-sm transition">
                            Buscar
                        </button>
                        @if(request('search') || request('date'))
                            <a href="{{ route('admin.orders.index') }}" class="w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-md text-sm transition">
                                Limpiar
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Contenedor de la Tabla -->
            <div class="bg-white shadow-lg sm:rounded-xl border border-gray-200 p-6">

                @if($orders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total (USD)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total (Bs)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th> <!-- Corregido: Cabecera añadida -->
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($orders as $order)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">{{ $order->id }}</td>
                                        <td class="px-6 py-4">{{ $order->customer_name }}</td>
                                        <td class="px-6 py-4">{{ $order->customer_email }}</td>
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
                    <p class="text-gray-600">No se encontraron órdenes con los criterios especificados.</p>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>