<x-front-layout>
    <section class="max-w-3xl mx-auto py-12 px-6">
        <h2 class="text-2xl font-bold mb-6">Checkout</h2>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-semibold mb-1">Full Name</label>
                <input type="text" name="name" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Email</label>
                <input type="email" name="email" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Shipping Address</label>
                <textarea name="address" class="w-full border rounded p-2" required></textarea>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Payment Method</label>
                <select name="payment" class="w-full border rounded p-2">
                    <option value="card">Credit/Debit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="transfer">Bank Transfer</option>
                </select>
            </div>

            <div class="text-right">
                <button type="submit" class="bg-pink-600 text-white px-6 py-2 rounded hover:bg-pink-700">
                    Confirm Order
                </button>
            </div>
        </form>
    </section>
</x-front-layout>