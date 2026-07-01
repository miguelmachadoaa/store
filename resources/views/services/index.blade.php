<x-front-layout>
    @section('title', 'Nuestros Servicios - ' . config('app.name'))
    @section('meta_description', 'Descubre todos nuestros servicios profesionales diseñados para ayudarte a alcanzar tus objetivos.')

    {{-- Hero Section --}}
    <div class="relative bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 text-white py-20">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="relative max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">Nuestros Servicios</h1>
            <p class="text-xl md:text-2xl text-indigo-100 max-w-3xl mx-auto">
                Soluciones profesionales diseñadas para impulsar tu éxito
            </p>
        </div>
    </div>

    {{-- Services Grid --}}
    <div class="max-w-7xl mx-auto px-6 py-16">
        @if($services->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($services as $service)
                    <div
                        class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-indigo-200">
                        @if($service->hero_image)
                            <div class="h-48 overflow-hidden">
                                <img src="{{ Storage::disk('r2')->url($service->hero_image) }}" alt="{{ $service->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            </div>
                        @endif

                        <div class="p-6">
                            @if($service->icon)
                                <div class="text-5xl mb-4">{{ $service->icon }}</div>
                            @endif

                            <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-indigo-600 transition">
                                {{ $service->name }}
                            </h3>

                            @if($service->short_description)
                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    {{ $service->short_description }}
                                </p>
                            @endif

                            @if($service->price)
                                <div class="mb-4">
                                    <span class="text-3xl font-bold text-indigo-600">${{ number_format($service->price, 2) }}</span>
                                    @if($service->price_description)
                                        <span class="text-gray-500">{{ $service->price_description }}</span>
                                    @endif
                                </div>
                            @endif

                            <a href="{{ route('services.show', $service->slug) }}"
                                class="inline-block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                                Ver Detalles →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <p class="text-gray-500 text-lg">No hay servicios disponibles en este momento.</p>
            </div>
        @endif
    </div>

    {{-- CTA Section --}}
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-16">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-4">¿Listo para comenzar?</h2>
            <p class="text-xl text-indigo-100 mb-8">
                Contáctanos hoy y descubre cómo podemos ayudarte a alcanzar tus objetivos
            </p>
            <a href="#contacto"
                class="inline-block bg-white text-indigo-600 font-bold py-4 px-8 rounded-lg hover:bg-gray-100 transition text-lg">
                Contáctanos Ahora
            </a>
        </div>
    </div>
</x-front-layout>