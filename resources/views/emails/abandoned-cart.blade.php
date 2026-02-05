<x-mail::message>
    # ¡Te extrañamos, {{ $cart->user->name }}!

    Notamos que dejaste algunos artículos increíbles en tu carrito. ¡No dejes que se escapen!

    Aquí tienes un resumen de lo que te espera:

    <x-mail::table>
        | Producto | Cantidad | Precio |
        | :------------- | :-----------: | :------------: |
        @foreach($cart->items as $item)
            | {{ $item->product->name }} | {{ $item->quantity }} | ${{ number_format($item->product->price, 2) }} |
        @endforeach
        | **Total** | | **${{ number_format($cart->total_amount, 2) }}** |
    </x-mail::table>

    <x-mail::button :url="route('cart.index')">
        Completar mi compra
    </x-mail::button>

    Si necesitas ayuda con tu pedido, estamos aquí para apoyarte.

    Gracias,<br>
    {{ config('app.name') }}
</x-mail::message>