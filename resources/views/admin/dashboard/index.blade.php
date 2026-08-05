<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Formulario de Filtros por Fecha --}}
            <div class="bg-white p-4 rounded-lg shadow border">
                <form action="{{ url()->current() }}" method="GET" class="flex flex-col sm:flex-row items-end gap-4">
                    <div class="w-full sm:w-auto">
                        <label for="from" class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                        <input type="date" name="from" id="from" value="{{ $startDate->format('Y-m-d') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div class="w-full sm:w-auto">
                        <label for="to" class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                        <input type="date" name="to" id="to" value="{{ $endDate->format('Y-m-d') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div class="w-full sm:w-auto flex gap-2">
                        <button type="submit" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md shadow-sm text-sm transition">
                            Filtrar
                        </button>
                        <a href="{{ url()->current() }}" class="w-full sm:w-auto bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-md text-sm text-center transition">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>

            {{-- Tarjetas de estadísticas --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-lg shadow border">
                    <h3 class="text-gray-500 text-sm">Total Ventas</h3>
                    <p class="text-3xl font-bold text-green-600">${{ number_format($totalSales, 2) }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow border">
                    <h3 class="text-gray-500 text-sm">Órdenes</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $totalOrders }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow border">
                    <h3 class="text-gray-500 text-sm">Productos</h3>
                    <p class="text-3xl font-bold text-pink-600">{{ $totalProducts }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow border">
                    <h3 class="text-gray-500 text-sm">Ticket Promedio</h3>
                    <p class="text-3xl font-bold text-pink-600">${{ number_format($totalSales / ($totalOrders ?: 1), 2) }}</p>
                </div>
            </div>

            {{-- Sección de Gráficas --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-lg shadow border">
                    <h3 class="text-lg font-bold mb-4">Ventas por Mes</h3>
                    <canvas id="salesChart" height="140"></canvas>
                </div>

                <div class="bg-white p-6 rounded-lg shadow border">
                    <h3 class="text-lg font-bold mb-4">Ventas Diarias en el Periodo</h3>
                    <canvas id="dailySalesChart" height="140"></canvas>
                </div>
            </div>

            {{-- Órdenes recientes --}}
            <div class="bg-white p-6 rounded-lg shadow border">
                <h3 class="text-lg font-bold mb-4">Órdenes en este Periodo</h3>
                @if($recentOrders->isEmpty())
                    <p class="text-gray-500 text-sm">No hay órdenes en las fechas seleccionadas.</p>
                @else
                    <table class="w-full">
                        <thead>
                            <tr class="border-b text-gray-500 text-left text-sm">
                                <th class="pb-2 font-semibold">ID</th>
                                <th class="pb-2 font-semibold">Cliente</th>
                                <th class="pb-2 font-semibold">Total</th>
                                <th class="pb-2 font-semibold">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                                <tr class="border-b hover:bg-gray-50 transition-colors">
                                    <td class="py-3">#{{ $order->id }}</td>
                                    <td class="py-3">{{ $order->customer_name }}</td>
                                    <td class="py-3 font-semibold text-gray-700">${{ number_format($order->total, 2) }}</td>
                                    <td class="py-3 text-sm text-gray-500">{{ $order->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            {{-- Productos más vendidos y favoritos --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-lg shadow border">
                    <h3 class="text-lg font-bold mb-4">Más Vendidos en este Periodo</h3>
                    <table class="w-full">
                        @forelse($topProducts as $product)
                            <tr class="border-b">
                                <td class="py-3 text-sm text-gray-700">{{ $product->name }}</td>
                                <td class="text-right text-sm font-semibold text-gray-600">{{ $product->total_qty }} vendidos</td>
                            </tr>
                        @empty
                            <tr><td class="py-3 text-sm text-gray-500">Sin datos de ventas.</td></tr>
                        @endforelse
                    </table>
                </div>

                <div class="bg-white p-6 rounded-lg shadow border">
                    <h3 class="text-lg font-bold mb-4">Más Deseados (Favoritos)</h3>
                    <table class="w-full">
                        @foreach($topWishlist as $product)
                            <tr class="border-b">
                                <td class="py-3 text-sm">
                                    <a href="{{ route('products.show', $product) }}" class="text-gray-700 hover:text-pink-600 transition">
                                        {{ $product->name }}
                                    </a>
                                </td>
                                <td class="text-right text-sm font-bold text-pink-600">
                                    ❤️ {{ $product->favorited_by_count }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            
            const ctxMonth = document.getElementById('salesChart').getContext('2d');
            new Chart(ctxMonth, {
                type: 'line',
                data: {
                    labels: {!! json_encode($salesByMonth->pluck('month')) !!},
                    datasets: [{
                        label: 'Ventas ($)',
                        data: {!! json_encode($salesByMonth->pluck('total')) !!},
                        borderColor: 'rgb(236, 72, 153)',
                        backgroundColor: 'rgba(236, 72, 153, 0.2)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: { responsive: true, maintainAspectRatio: true }
            });

            const ctxDay = document.getElementById('dailySalesChart').getContext('2d');
            new Chart(ctxDay, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($salesByDay->pluck('day')->map(fn($date) => \Carbon\Carbon::parse($date)->format('d/m'))) !!},
                    datasets: [{
                        label: 'Ventas por Día ($)',
                        data: {!! json_encode($salesByDay->pluck('total')) !!},
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: { y: { beginAtZero: true } }
                }
            });
        });
    </script>
</x-app-layout>