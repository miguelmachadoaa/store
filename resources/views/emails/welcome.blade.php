<x-mail::message>
    # ¡Hola, {{ $user->name }}!

    Estamos muy emocionados de tenerte en **{{ config('app.name') }}**. Gracias por registrarte en nuestra tienda.

    En nuestra plataforma encontrarás los mejores productos tecnológicos con la mejor atención y los precios más
    competitivos del mercado.

    <x-mail::panel>
        Como regalo de bienvenida, usa el código **BIENVENIDO10** en tu primera compra para obtener un **10% de
        descuento**.
    </x-mail::panel>

    <x-mail::button :url="route('shop.index')">
        Empezar a comprar
    </x-mail::button>

    Si tienes alguna pregunta, no dudes en contactarnos respondiendo a este correo.

    Saludos,<br>
    El equipo de {{ config('app.name') }}
</x-mail::message>