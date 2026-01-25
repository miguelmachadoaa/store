<x-front-layout>
    <section class="max-w-7xl mx-auto py-12 px-6">
        <h2 class="text-2xl font-bold mb-6">Your Cart</h2>

        @if(count($cart) > 0)
            <div class="overflow-x-auto bg-white shadow rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php $total = 0; @endphp
                        @foreach($cart as $id => $item)
                            @php $total += $item['price'] * $item['quantity']; @endphp
                            <tr>
                                <td class="px-6 py-4">{{ $item['name'] }}</td>
                                <td class="px-6 py-4">${{ number_format($item['price'], 2) }}</td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('cart.update', $id) }}" method="POST">
                                        @csrf
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                               min="1" class="w-16 border rounded p-1">
                                        <button class="text-blue-600 ml-2">Update</button>
                                    </form>
                                </td>
                                <td class="px-6 py-4">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        <button class="text-red-600">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <tr class="font-bold">
                            <td colspan="3" class="px-6 py-4 text-right">Total:</td>
                            <td class="px-6 py-4">${{ number_format($total, 2) }}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-6 text-right">
                <a href="{{ route('checkout.index') }}" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                    Proceed to Checkout
                </a>
            </div>
        @else
            <p class="text-gray-600">Your cart is empty.</p>
        @endif
    </section>
</x-front-layout>