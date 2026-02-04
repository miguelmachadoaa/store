<x-front-layout>
    <section class="max-w-3xl mx-auto py-12 px-6 text-center">
        <h2 class="text-3xl font-bold text-green-600 mb-4">Order Completed!</h2>
        <p class="text-gray-700 mb-6">Thank you for your purchase, {{ $order->customer_name }}.</p>

        <div class="bg-white shadow rounded p-6 text-left">
            <h3 class="text-xl font-semibold mb-4">Order Summary</h3>

            <ul class="space-y-2">
                @foreach($order->items as $item)
                    <li class="flex justify-between border-b pb-2">
                        <div class="flex flex-col">
                            <span>{{ $item->name }} (x{{ $item->quantity }})</span>
                            @if($item->total_bs)
                                <span class="text-xs text-indigo-600 font-medium">Bs.
                                    {{ number_format($item->total_bs, 2) }}</span>
                            @endif
                        </div>
                        <div class="flex flex-col text-right">
                            <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="text-right mt-4 flex flex-col items-end">
                @if($order->taxable_base)
                    <div class="text-xs text-gray-500">Base Imponible: ${{ number_format($order->taxable_base, 2) }}</div>
                    <div class="text-xs text-gray-500 pb-2">Impuesto (IVA): ${{ number_format($order->tax_amount, 2) }}
                    </div>
                @endif
                <div class="text-xl font-bold">Total: ${{ number_format($order->total, 2) }}</div>
                @if($order->total_bs)
                    <div class="text-sm text-indigo-600 font-bold">Total en Bolívares: Bs.
                        {{ number_format($order->total_bs, 2) }}</div>
                @endif
            </div>
        </div>

        <a href="{{ route('home') }}"
            class="mt-6 inline-block bg-pink-600 text-white px-6 py-2 rounded hover:bg-pink-700">
            Back to Home
        </a>
    </section>
</x-front-layout>