<x-front-layout>
    <section class="max-w-3xl mx-auto py-12 px-6">
        <h2 class="text-2xl font-bold mb-6">Checkout</h2>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-semibold mb-1">Full Name</label>
                <input type="text" name="name" value="{{ $user->name }}" class="w-full border rounded p-2 bg-gray-50"
                    readonly>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="w-full border rounded p-2 bg-gray-50"
                    readonly>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">C.I. / RIF</label>
                <input type="text" name="rif" value="{{ old('rif', $user->rif) }}"
                    class="w-full border rounded p-2 @error('rif') border-red-500 @enderror" required
                    placeholder="V-12345678-0">
                @error('rif')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                    class="w-full border rounded p-2 @error('phone') border-red-500 @enderror" required>
                @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Shipping Address</label>
                <textarea name="address" class="w-full border rounded p-2 @error('address') border-red-500 @enderror"
                    required>{{ old('address', $user->address) }}</textarea>
                @error('address')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Payment Method</label>
                <select name="payment" class="w-full border rounded p-2">
                    <option value="card">Credit/Debit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="transfer">Bank Transfer</option>
                </select>
            </div>

            <div class="mb-8 p-6 bg-gray-50 rounded-lg border">
                <h3 class="font-bold text-lg mb-4">Resumen del Pedido</h3>
                @php
                    $subtotal = 0;
                    foreach ($cart as $item) {
                        $subtotal += $item['price'] * $item['quantity'];
                    }
                    $discount = session('coupon.discount', 0);
                    $total = $subtotal - $discount;
                @endphp
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span>Subtotal:</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>
                    @if($discount > 0)
                        <div class="flex justify-between text-green-600">
                            <span>Descuento ({{ session('coupon.code') }}):</span>
                            <span>-${{ number_format($discount, 2) }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between font-bold text-xl border-t pt-2 mt-2">
                        <span>Total:</span>
                        <span class="text-indigo-700">${{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="text-right">
                <button type="submit"
                    class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 font-bold shadow-md transition transform hover:-translate-y-0.5">
                    Confirm Order / Confirmar Pedido
                </button>
            </div>
        </form>
    </section>
</x-front-layout>