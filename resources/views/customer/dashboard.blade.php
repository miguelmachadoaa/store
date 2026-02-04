<x-customer-layout>
    <div class="bg-white shadow rounded-lg p-6 border border-gray-100">
        <h1 class="text-2xl font-bold mb-2">Bienvenido, {{ $user->name }}</h1>
        <p class="text-gray-600 mb-8">Desde tu panel de control puedes ver tus compras recientes, gestionar tus reportes
            de pago y actualizar tu información de perfil.</p>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-indigo-50 p-4 rounded-lg flex items-center gap-4">
                <div class="p-3 bg-indigo-500 text-white rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-indigo-900">{{ $ordersCount }}</div>
                    <div class="text-sm text-indigo-600">Total de Órdenes</div>
                </div>
            </div>

            <div class="bg-pink-50 p-4 rounded-lg flex items-center gap-4">
                <div class="p-3 bg-pink-500 text-white rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-pink-900">{{ $paymentsCount }}</div>
                    <div class="text-sm text-pink-600">Pagos Reportados</div>
                </div>
            </div>

            <div class="bg-green-50 p-4 rounded-lg flex items-center gap-4">
                <div class="p-3 bg-green-500 text-white rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-green-900">Activo</div>
                    <div class="text-sm text-green-600">Estado de Cuenta</div>
                </div>
            </div>
        </div>

        {{-- Recent Orders --}}
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Órdenes Recientes</h2>
            <a href="{{ route('customer.orders') }}" class="text-indigo-600 hover:underline text-sm font-medium">Ver
                todas</a>
        </div>

        <div class="overflow-x-auto border rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orden
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                            (BS)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentOrders as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-indigo-600 font-bold">
                                #{{ $order->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">Bs.
                                {{ number_format($order->total_bs, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->status_badge }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500 italic">No tienes compras aún.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-customer-layout>