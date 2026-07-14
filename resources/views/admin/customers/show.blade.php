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
                <h3 class="text-lg font-bold mb-4 border-b pb-2">👤 Información del Cliente</h3>

                <div class="grid md:grid-cols-2 gap-4 mb-8 text-sm">
                    <div class="space-y-2">
                        <p><strong class="text-gray-500">Nombre:</strong> <span class="text-gray-900 font-semibold">{{ $user->name }}</span></p>
                        <p><strong class="text-gray-500">Cédula / RIF:</strong> <span class="text-gray-900 font-semibold">{{ $user->rif ?? $user->customer_rif ?? 'No registrado' }}</span></p>
                        <p><strong class="text-gray-500">Email:</strong> <span class="text-indigo-600 font-semibold break-all">{{ $user->email }}</span></p>
                    </div>
                    <div class="space-y-2">
                        <p><strong class="text-gray-500">Registrado:</strong> <span class="text-gray-900 font-semibold">{{ $user->created_at->format('d/m/Y H:i') }}</span></p>
                        
                        {{-- Campo de Teléfono incorporado --}}
                        <div class="flex items-center gap-2">
                            <strong class="text-gray-500">Teléfono:</strong> 
                            <span class="text-gray-900 font-semibold">{{ $user->phone ?? 'No registrado' }}</span>
                            @if($whatsappUrl)
                                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" 
                                class="inline-flex items-center gap-1 bg-green-100 hover:bg-green-200 text-green-700 font-bold px-2 py-0.5 rounded text-xs transition border border-green-200"
                                title="Enviar mensaje de WhatsApp">
                                💬 WhatsApp
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Órdenes del cliente --}}
                <h3 class="text-lg font-bold mb-4 border-b pb-2">📦 Órdenes del Cliente</h3>

                @if($orders->count() > 0)
                    <div class="overflow-x-auto mb-8">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
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
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 font-semibold text-gray-900">#{{ $order->id }}</td>
                                        <td class="px-6 py-4 text-gray-700 font-medium">${{ number_format($order->total, 2) }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full {{ $order->status_badge }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">{{ $order->created_at->format('d/m/Y') }}</td>
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
                    </div>

                @else
                    <div class="bg-gray-50 rounded-xl p-6 text-center text-gray-500 text-sm border border-dashed border-gray-200 mb-8">
                        Este cliente no tiene órdenes registradas en la plataforma.
                    </div>
                @endif

                <hr class="my-8 border-gray-200">

                {{-- Wishlist del cliente --}}
                <h3 class="text-lg font-bold mb-4 border-b pb-2">⭐ Lista de Deseos (Favoritos)</h3>

                @if($user->favorites->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        @foreach($user->favorites as $favorite)
                            <div class="border rounded-lg p-2 bg-gray-50 text-center shadow-sm hover:shadow transition">
                                <img src="{{ $favorite->image ? Storage::disk('r2')->url($favorite->image) : asset('images/no-image.png') }}"
                                     class="w-full h-24 object-cover rounded mb-2">
                                <p class="text-xs font-semibold truncate text-gray-800">{{ $favorite->name }}</p>
                                <p class="text-indigo-600 text-xs font-bold mt-0.5">${{ number_format($favorite->price, 2) }}</p>
                                <a href="{{ route('products.show', $favorite) }}"
                                   class="text-[10px] text-gray-500 hover:underline block mt-1">Ver Producto</a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50 rounded-xl p-6 text-center text-gray-500 text-sm border border-dashed border-gray-200">
                        Este cliente no tiene productos en su lista de deseos.
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>