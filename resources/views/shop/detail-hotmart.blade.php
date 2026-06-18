<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->meta_title ?? $product->name }}</title>
    <meta name="description" content="{{ $product->meta_description ?? Str::limit($product->description, 150) }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans text-gray-900 antialiased">

    <div class="bg-red-600 text-white text-center py-2 text-sm font-semibold tracking-wide px-4">
        ⚠️ ¡ATENCIÓN! Oferta especial por tiempo limitado. Quedan pocos cupos/unidades disponibles.
    </div>

    <header class="bg-white border-b border-gray-100 py-12 lg:py-20">
        <div class="max-w-5xl mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight text-gray-900 leading-tight mb-4">
                {{ $product->landing_headline ?? $product->name }}
            </h1>
            <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto mb-8">
                {{ $product->landing_subheadline ?? $product->description }}
            </p>

            <div class="max-w-3xl mx-auto aspect-video bg-black rounded-2xl shadow-2xl overflow-hidden mb-10 border-4 border-white">
                @if($product->landing_video_url)
                    @php
                        // Helper rápido para convertir enlaces de YouTube normales a formato embed
                        $embedUrl = str_replace(['watch?v=', 'youtu.be/'], ['embed/', 'youtube.com/embed/'], $product->landing_video_url);
                    @endphp
                    <iframe class="w-full h-full" src="{{ $embedUrl }}" title="Presentación del producto" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                @else
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                @endif
            </div>

            <div class="flex flex-col items-center">
                <form action="{{ route('cart.buy-now', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white text-xl md:text-2xl font-bold px-8 py-5 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all w-full sm:w-auto uppercase tracking-wide">
                        ¡Sí, Quiero Adquirirlo Ahora!
                    </button>
                </form>
                <div class="mt-3 flex items-center space-x-2 text-sm text-gray-500">
                    <span>🔒 Compra 100% Segura</span>
                    <span>•</span>
                    <span>Entrega Inmediata</span>
                </div>
            </div>
        </div>
    </header>

    @if(!empty($product->landing_benefits))
    <section class="py-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-center text-gray-900 mb-12">Lo que vas a lograr con este producto:</h2>
            <div class="grid gap-6 md:grid-cols-2">
                @foreach($product->landing_benefits as $benefit)
                    <div class="flex items-start bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        <div class="flex-shrink-0 bg-green-100 text-green-600 rounded-full p-2 mr-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <p class="text-gray-700 font-medium">{{ $benefit }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if(!empty($product->landing_target_public))
    <section class="py-16 bg-white border-t border-b border-gray-100">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-12">¿Es esto adecuado para ti?</h2>
            <div class="grid gap-8 md:grid-cols-2">
                <div class="bg-emerald-50/50 p-6 rounded-2xl border border-emerald-100">
                    <h3 class="text-lg font-bold text-emerald-800 mb-4 flex items-center">
                        <span class="mr-2 text-xl">👍</span> Esto es ideal para ti si:
                    </h3>
                    <ul class="space-y-3 text-emerald-950 text-sm">
                        @foreach($product->landing_target_public['si'] ?? $product->landing_target_public as $item)
                            @if(is_string($item)) <li>• {{ $item }}</li> @endif
                        @endforeach
                    </ul>
                </div>
                <div class="bg-rose-50/50 p-6 rounded-2xl border border-rose-100">
                    <h3 class="text-lg font-bold text-rose-800 mb-4 flex items-center">
                        <span class="mr-2 text-xl">👎</span> Esto NO es para ti si:
                    </h3>
                    <ul class="space-y-3 text-rose-950 text-sm">
                        @foreach($product->landing_target_public['no'] ?? [] as $item)
                            <li>• {{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
    @endif

    @if(!empty($product->landing_testimonials))
    <section class="py-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-12">Lo que dicen quienes ya lo han probado</h2>
            <div class="grid gap-6 md:grid-cols-2">
                @foreach($product->landing_testimonials as $testimonial)
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between">
                        <p class="text-gray-600 italic mb-4">"{{ $testimonial['text'] ?? $testimonial }}"</p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold mr-3 text-sm">
                                {{ strtoupper(substr($testimonial['name'] ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-gray-800">{{ $testimonial['name'] ?? 'Cliente Satisfecho' }}</h4>
                                <div class="text-yellow-400 text-xs">⭐⭐⭐⭐⭐</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if(!empty($product->landing_bonuses))
    <section class="py-16 bg-indigo-900 text-white">
        <div class="max-w-4xl mx-auto px-4">
            <div class="text-center mb-12">
                <span class="bg-indigo-700 text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full">Regalos Adicionales</span>
                <h2 class="text-2xl md:text-4xl font-extrabold mt-3">Y si ordenas hoy, te llevas estos Bonus GRATIS:</h2>
            </div>
            <div class="space-y-6">
                @foreach($product->landing_bonuses as $index => $bonus)
                    <div class="bg-indigo-950/60 p-6 rounded-xl border border-indigo-700/50 flex flex-col sm:flex-row items-start sm:items-center justify-between">
                        <div class="mb-4 sm:mb-0">
                            <span class="text-emerald-400 font-bold text-sm uppercase">BONUS #{{ $index + 1 }}</span>
                            <h3 class="text-lg font-bold">{{ $bonus['title'] ?? $bonus }}</h3>
                            <p class="text-indigo-200 text-sm mt-1">{{ $bonus['description'] ?? 'Acceso inmediato incluido con tu orden.' }}</p>
                        </div>
                        <div class="text-emerald-400 font-bold bg-indigo-900 px-4 py-2 rounded-lg border border-indigo-700">
                            VALORADO EN: ${{ $bonus['value'] ?? '19.99' }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <section class="py-16 bg-white">
        <div class="max-w-3xl mx-auto px-4">
            <div class="bg-yellow-50 border-2 border-dashed border-yellow-400 rounded-3xl p-8 md:p-12 text-center shadow-xl">
                <h3 class="text-xl md:text-2xl font-extrabold text-gray-900 uppercase tracking-wide mb-2">Oferta Especial de Lanzamiento</h3>
                <h4 class="text-2xl md:text-3xl font-bold text-indigo-900 mb-6">{{ $product->name }}</h4>
                
                <div class="flex flex-col items-center justify-center mb-6">
                    @if($product->hasDiscount())
                        <span class="text-gray-400 line-through text-lg">Antes: ${{ number_with_format($product->compare_price) }} / {{ number_with_format($product->compare_price_bs) }} Bs.</span>
                    @endif
                    <div class="mt-1">
                        <span class="text-4xl md:text-6xl font-black text-red-600">${{ number_format($product->price, 2) }}</span>
                    </div>
                    <span class="text-xl font-bold text-gray-700 mt-1">Ó {{ number_format($product->price_bs, 2) }} Bs.</span>
                </div>

                <form action="{{ route('cart.buy-now', $product->id) }}" method="POST" class="mb-8">
                    @csrf
                    <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white text-xl md:text-2xl font-black py-5 px-6 rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-102 transition-all uppercase tracking-wide animate-pulse">
                        🚀 ¡Comprar y Registrarme Ahora!
                    </button>
                </form>

                <div class="border-t border-yellow-200 pt-6 flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6 text-left">
                    <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center text-3xl flex-shrink-0 shadow-inner">🏅</div>
                    <div>
                        <h5 class="font-bold text-gray-900 text-lg">Garantía Incondicional de {{ $product->landing_warranty_days }} Días</h5>
                        <p class="text-sm text-gray-600 mt-1">Prueba nuestro producto sin riesgos. Si en los primeros {{ $product->landing_warranty_days }} días sientes que no cumple tus expectativas, te devolvemos el 100% de tu dinero sin preguntas.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-950 text-gray-500 text-xs py-8 text-center border-t border-gray-900 px-4">
        <p class="mb-2">© {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
        <p class="max-w-2xl mx-auto opacity-70">Este sitio web no está afiliado a Hotmart ni a ninguna plataforma externa. Los resultados pueden variar según el caso de uso individual.</p>
    </footer>

</body>
</html>