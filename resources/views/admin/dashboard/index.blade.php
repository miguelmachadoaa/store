<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Tarjetas de estadísticas --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

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

            </div>

            {{-- Sección de Gráficas (Lado a Lado) --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Gráfica de ventas por mes --}}
                <div class="bg-white p-6 rounded-lg shadow border">
                    <h3 class="text-lg font-bold mb-4">Ventas por Mes</h3>
                    <canvas id="salesChart" height="140"></canvas>
                </div>

                {{-- Gráfica de ventas últimos 30 días --}}
                <div class="bg-white p-6 rounded-lg shadow border">
                    <h3 class="text-lg font-bold mb-4">Ventas Diarias (Últimos 30 días)</h3>
                    <canvas id="dailySalesChart" height="140"></canvas>
                </div>

            </div>

            {{-- Órdenes recientes --}}
            <div class="bg-white p-6 rounded-lg shadow border">
                <h3 class="text-lg font-bold mb-4">Órdenes Recientes</h3>

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
            </div>

            {{-- Productos más vendidos y más deseados --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Productos más vendidos --}}
                <div class="bg-white p-6 rounded-lg shadow border">
                    <h3 class="text-lg font-bold mb-4">Productos Más Vendidos</h3>
                    <table class="w-full">
                        @foreach($topProducts as $product)
                            <tr class="border-b">
                                <td class="py-3 text-sm text-gray-700">{{ $product->name }}</td>
                                <td class="text-right text-sm font-semibold text-gray-600">{{ $product->total_qty }} vendidos</td>
                            </tr>
                        @endforeach
                    </table>
                </div>

                {{-- Productos más Favoritos --}}
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

    {{-- Script unificado para la renderización de gráficos con Chart.js --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            
            // 1. Configuración de Gráfica Mensual (Original)
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
                options: {
                    responsive: true,
                    maintainAspectRatio: true
                }
            });

            // 2. Configuración de Gráfica Diaria (Nueva - Últimos 30 días)
            const ctxDay = document.getElementById('dailySalesChart').getContext('2d');
            new Chart(ctxDay, {
                type: 'bar', // Tipo barra optimiza la lectura de volúmenes diarios
                data: {
                    // Mapeamos las fechas a formato d/m para que el eje X se vea limpio
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
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

        });
    </script>
</x-app-layout>