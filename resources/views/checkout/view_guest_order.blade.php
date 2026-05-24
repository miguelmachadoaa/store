<x-front-layout>
    <section class="max-w-2xl mx-auto py-12 px-6">
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <div class="flex justify-between items-center border-b pb-4 mb-4">
                <h2 class="text-xl font-bold text-gray-800">Estado del Pedido #{{ $order->id }}</h2>
                <span class="px-3 py-1 text-xs font-semibold uppercase rounded-full 
                    {{ $order->status === 'pendiente' || $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                    {{ $order->status }}
                </span>
            </div>

            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-50 rounded-lg">{{ session('success') }}</div>
            @endif

            <p class="text-sm text-gray-600 mb-2"><strong>Cliente:</strong> {{ $order->customer_name }}</p>
            <p class="text-sm text-gray-600 mb-4"><strong>Dirección:</strong> {{ $order->address }}</p>

            <h3 class="font-semibold text-gray-700 mb-2 text-sm uppercase tracking-wider">Productos</h3>
            <ul class="divide-y mb-6">
                @foreach($order->items as $item)
                    <li class="py-2.5 flex justify-between text-sm">
                        <span>{{ $item->name }} (x{{ $item->quantity }})</span>
                        <span class="font-medium">${{ number_format($item->price * $item->quantity, 2) }}</span>
                    </li>
                @endforeach
            </ul>

            <div class="text-right border-t pt-4">
                <p class="text-lg font-bold text-indigo-600">Total: ${{ number_format($order->total, 2) }}</p>
                <p class="text-sm text-gray-500">Ref (Bs.): Bs. {{ number_format($order->total_bs, 2) }}</p>
            </div>

            @if($order->status === 'pendiente' || $order->status === 'pending')
                <div class="mt-6 pt-6 border-t">
                    <a href="{{ URL::signedRoute('guest.payments.report', ['orderId' => $order->id]) }}" 
                       class="block text-center w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition">
                        💳 Reportar Pago para este Pedido
                    </a>
                </div>
            @endif
        </div>
    </section>
</x-front-layout>