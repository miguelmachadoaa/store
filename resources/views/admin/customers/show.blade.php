<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Cliente: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg sm:rounded-xl border border-gray-200 p-6">

                {{-- Información del cliente --}}
                <h3 class="text-lg font-bold mb-4">Información del Cliente</h3>

                <div class="grid md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p><strong>Nombre:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                    </div>
                    <div>
                        <p><strong>Registrado:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                {{-- Órdenes del cliente --}}
                <h3 class="text-lg font-bold mb-4">Órdenes del Cliente</h3>

                @if($orders->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($orders as $order)
                                <tr>
                                    <td class="px-6 py-4">#{{ $order->id }}</td>
                                    <td class="px-6 py-4">${{ number_format($order->total, 2) }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-3 py-1 inline-flex text-xs font-semibold rounded-full {{ $order->status_badge }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                            class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                            Ver Orden
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                @else
                    <p class="text-gray-600">Este cliente no tiene órdenes.</p>
                @endif

                <hr class="my-8 border-gray-200">

                {{-- Wishlist del cliente --}}
                <h3 class="text-lg font-bold mb-4">Lista de Deseos (Favoritos)</h3>

                @if($user->favorites->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        @foreach($user->favorites as $favorite)
                            <div class="border rounded-lg p-2 bg-gray-50 text-center">
                                <img src="{{ $favorite->image ? Storage::disk('r2')->url($favorite->image) : asset('images/no-image.png') }}"
                                    class="w-full h-24 object-cover rounded mb-2">
                                <p class="text-xs font-semibold truncate">{{ $favorite->name }}</p>
                                <p class="text-indigo-600 text-xs">${{ number_format($favorite->price, 2) }}</p>
                                <a href="{{ route('products.show', $favorite) }}"
                                    class="text-[10px] text-gray-500 hover:underline">Ver Producto</a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600">Este cliente no tiene productos en su lista de deseos.</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>