<x-front-layout :sliders="$sliders" :brands="[]">

<style>
   
</style>

{{-- ╔══════════════════════╗
     ║  Trust bar           ║
     ╚══════════════════════╝ --}}
{{-- Inicializamos el estado del modal en el contenedor principal usando Alpine.js --}}
<div class="trust-bar" x-data="{ openEnergyModal: false }">
    <div class="trust-bar__inner">
        @foreach([
            ['icon' => '💬', 'title' => 'Soporte 24/7',        'sub' => 'Siempre disponibles para ti', 'modal' => false],
            ['icon' => '🚚', 'title' => 'Envío gratuito',       'sub' => 'En pedidos desde $20',        'modal' => false],
            ['icon' => '🔒', 'title' => 'Pago seguro',          'sub' => 'Pago Móvil y Tarjeta',        'modal' => false],
            ['icon' => '✨', 'title' => 'Garantía de energía',  'sub' => 'Piedras certificadas',        'modal' => true],
        ] as $trust)
            
            {{-- Si el elemento tiene 'modal' => true, le agregamos interactividad --}}
            @if($trust['modal'])
                <div class="trust-item cursor-pointer hover:opacity-80 transition-opacity" @click="openEnergyModal = true">
                    <div class="trust-item__icon">{{ $trust['icon'] }}</div>
                    <div class="trust-item__text">
                        <strong>{{ $trust['title'] }} <span class="text-pink-600 text-xs font-normal underline ml-1">(Saber más)</span></strong>
                        {{ $trust['sub'] }}
                    </div>
                </div>
            @else
                {{-- Elementos normales sin modal --}}
                <div class="trust-item">
                    <div class="trust-item__icon">{{ $trust['icon'] }}</div>
                    <div class="trust-item__text">
                        <strong>{{ $trust['title'] }}</strong>
                        {{ $trust['sub'] }}
                    </div>
                </div>
            @endif

        @endforeach
    </div>

    {{-- Ventana Emergente (Modal de Confianza) --}}
    <div x-show="openEnergyModal" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" 
         x-transition
         @keydown.escape.window="openEnergyModal = false"
         style="display: none;">
        
        {{-- Fondo del modal --}}
        <div class="absolute inset-0" @click="openEnergyModal = false"></div>

        {{-- Contenedor del contenido --}}
        <div class="bg-white p-6 rounded-2xl max-w-sm w-full shadow-2xl relative z-10 border border-gray-100 text-center">
            {{-- Icono destacado --}}
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-pink-100 text-pink-600 mb-4">
                ✨
            </div>
            
            <h3 class="text-lg font-bold text-gray-900 mb-2">Nuestra Garantía de Autenticidad</h3>
            
            <p class="text-sm text-gray-600 leading-relaxed mb-6">
                Cada una de nuestras piezas es seleccionada y analizada minuciosamente para asegurar que recibes <strong>gemas 100% naturales</strong> y genuinas. Garantizamos su origen mineral para que aproveches al máximo sus propiedades y vibración energética original, libres de imitaciones plásticas o sintéticas.
            </p>

            <button @click="openEnergyModal = false" 
                    class="w-full bg-pink-600 hover:bg-pink-700 text-white py-2.5 px-4 rounded-xl text-sm font-semibold transition-all duration-200 shadow-sm active:scale-95">
                Entendido
            </button>
        </div>
    </div>
</div>

{{-- ╔══════════════════════╗
     ║  Categorías          ║
     ╚══════════════════════╝ --}}
@if(isset($categories) && $categories->count() > 0)
<section class="cat-section">
    <div class="cat-section__inner">
        <p class="section-eyebrow">Explora nuestra colección</p>
        <h2 class="section-title">Pulseras por <em>piedra</em> y propósito</h2>

        <div class="cat-grid">
            @forelse($categories as $category)
                <a href="{{ route('shop.byCategory', $category->slug) }}" class="cat-card">
                    <div class="cat-card__img">
                        @if($category->image)
                            <img src="{{ Storage::disk('r2')->url($category->image) }}" alt="{{ $category->name }}">
                        @else
                            <div class="cat-card__placeholder">🔮</div>
                        @endif
                    </div>
                    <div class="cat-card__label">
                        {{ $category->name }}
                        <span>→</span>
                    </div>
                </a>
            @empty
                <p style="grid-column:1/-1;text-align:center;color:var(--ap-stone)">
                    Sin categorías disponibles aún.
                </p>
            @endforelse
        </div>
    </div>
</section>
@endif

{{-- ╔══════════════════════╗
     ║  Deal of the Week    ║
     ╚══════════════════════╝ --}}
<section class="products-section">
    <div class="products-section__inner">
        <div class="deal-banner">
            <div class="deal-banner__text">
                <p class="eyebrow">Oferta especial · Esta semana</p>
                <h2>Descuentos de hasta <em>50% off</em></h2>
            </div>
            <a href="{{ route('shop.index') }}" class="deal-banner__cta">Ver todas las ofertas →</a>
        </div>

        <div class="products-grid-4">
            @foreach($weeklyDeals as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>
</section>

{{-- ╔══════════════════════╗
     ║  Nuevos productos    ║
     ╚══════════════════════╝ --}}
<section class="products-section products-section--alt">
    <div class="products-section__inner">
        <p class="section-eyebrow">Recién llegadas</p>
        <h2 class="section-title">Nuevas <em>piezas</em> para ti</h2>

        <div class="products-grid-3">
            @foreach($recentProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>

        <div class="section-cta-wrap">
            <a href="{{ route('shop.index') }}" class="section-cta">Ver toda la tienda →</a>
        </div>
    </div>
</section>

{{-- ╔══════════════════════╗
     ║  Newsletter          ║
     ╚══════════════════════╝ --}}
<section class="newsletter-section">
    <div class="newsletter-inner">
        <p class="newsletter-eyebrow">Comunidad holística</p>
        <h2 class="newsletter-title">Únete a nuestra <em>energía</em></h2>
        <p class="newsletter-sub">
            Recibe rituales de uso, guías de piedras y ofertas exclusivas directamente en tu correo.
        </p>

        <form action="{{ route('newsletter.store') }}" method="POST" class="newsletter-form"
              onsubmit="if(typeof fbq !== 'undefined') { fbq('track', 'Lead', { content_name: 'Newsletter Subscription' }); }">
            @csrf
            <input type="email" name="email" class="newsletter-input"
                   placeholder="tucorreo@ejemplo.com" required>
            <button type="submit" class="newsletter-btn">Suscribirme</button>
        </form>

        @if(session('success'))
            <p class="newsletter-success">✦ {{ session('success') }}</p>
        @endif
    </div>
</section>

{{-- ╔══════════════════════╗
     ║  Latest news         ║
     ╚══════════════════════╝ --}}
<x-latest-news />

{{-- ╔══════════════════════╗
     ║  Promo strip         ║
     ╚══════════════════════╝ --}}
<div class="promo-strip">
    <h2>Encuentra tu <em>piedra</em> perfecta</h2>
    <p>Cada pulsera lleva consigo siglos de energía natural y propósito</p>
    <a href="{{ route('shop.index') }}">Explorar colección</a>
</div>

</x-front-layout>