<x-front-layout>
    <section class="max-w-3xl mx-auto py-12 px-6 text-center">
        <h2 class="text-3xl font-bold text-green-600 mb-4">Order Completed!</h2>
        <p class="text-gray-700 mb-6">Thank you for your purchase, {{ $order->customer_name }}.</p>

        <div class="bg-white shadow rounded p-6 text-left">
            <h3 class="text-xl font-semibold mb-4">Order Summary</h3>

            <ul class="space-y-2">
                @foreach($order->items as $item)
                    <li class="flex justify-between border-b pb-2">
                        <span>{{ $item->name }} (x{{ $item->quantity }})</span>
                        <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
                    </li>
                @endforeach
            </ul>

            <div class="text-right mt-4 text-xl font-bold">
                Total: ${{ number_format($order->total, 2) }}
            </div>
        </div>

        <a href="{{ route('home') }}" class="mt-6 inline-block bg-pink-600 text-white px-6 py-2 rounded hover:bg-pink-700">
            Back to Home
        </a>
    </section>
</x-front-layout>