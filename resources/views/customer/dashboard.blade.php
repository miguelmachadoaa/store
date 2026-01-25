<x-front-layout>

    <div class="max-w-5xl mx-auto py-12 px-6">

        <h2 class="text-2xl font-bold mb-6">Mi Cuenta</h2>

        <h3 class="text-xl font-semibold mb-4">Mis Compras</h3>

        @if($orders->count())
            <table class="w-full border">
                @foreach($orders as $order)
                    <tr class="border-b">
                        <td class="p-3">#{{ $order->id }}</td>
                        <td class="p-3">${{ number_format($order->total, 2) }}</td>
                        <td class="p-3">{{ $order->created_at->format('d/m/Y') }}</td>
                        <td class="p-3">
                            <a href="{{ route('order.show', $order) }}" class="text-pink-600">Ver</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <p>No tienes compras registradas.</p>
        @endif

    </div>

</x-front-layout>