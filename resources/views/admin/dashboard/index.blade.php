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

            {{-- Gráfica de ventas por mes --}}
            <div class="bg-white p-6 rounded-lg shadow border">
                <h3 class="text-lg font-bold mb-4">Ventas por Mes</h3>

                <canvas id="salesChart" height="100"></canvas>

                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const ctx = document.getElementById('salesChart').getContext('2d');

                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: {!! json_encode($salesByMonth->pluck('month')) !!},
                                datasets: [{
                                    label: 'Ventas ($)',
                                    data: {!! json_encode($salesByMonth->pluck('total')) !!},
                                    borderColor: 'rgb(236, 72, 153)',
                                    backgroundColor: 'rgba(236, 72, 153, 0.2)',
                                    borderWidth: 2,
                                    tension: 0.3
                                }]
                            }
                        });
                    });
                </script>
            </div>

            {{-- Órdenes recientes --}}
            <div class="bg-white p-6 rounded-lg shadow border">
                <h3 class="text-lg font-bold mb-4">Órdenes Recientes</h3>

                <table class="w-full">
                    @foreach($recentOrders as $order)
                        <tr class="border-b">
                            <td class="py-2">#{{ $order->id }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>${{ number_format($order->total, 2) }}</td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>

            {{-- Productos más vendidos --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-lg shadow border">
                    <h3 class="text-lg font-bold mb-4">Productos Más Vendidos</h3>
                    <table class="w-full">
                        @foreach($topProducts as $product)
                            <tr class="border-b">
                                <td class="py-2 text-sm">{{ $product->name }}</td>
                                <td class="text-right text-sm font-semibold">{{ $product->total_qty }} vendidos</td>
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
                                <td class="py-2 text-sm">
                                    <a href="{{ route('products.show', $product) }}" class="hover:text-pink-600 transition">
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
</x-app-layout>