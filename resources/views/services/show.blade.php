<x-front-layout>
    @section('title', $service->meta_title ?: $service->name . ' - ' . config('app.name'))
    @section('meta_description', $service->meta_description ?: $service->short_description)

    {{-- Hero Section with Background Image --}}
    <div class="relative bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 text-white py-24 overflow-hidden">
        @if($service->hero_image)
            <div class="absolute inset-0">
                <img src="{{ Storage::disk('r2')->url($service->hero_image) }}" 
                    alt="{{ $service->name }}"
                    class="w-full h-full object-cover opacity-20">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-900/80 to-purple-900/80"></div>
            </div>
        @endif
        
        <div class="relative max-w-7xl mx-auto px-6">
            <div class="max-w-3xl">
                @if($service->icon)
                    <div class="text-7xl mb-6">{{ $service->icon }}</div>
                @endif
                
                <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                    {{ $service->hero_title ?: $service->name }}
                </h1>
                
                @if($service->hero_subtitle)
                    <p class="text-xl md:text-2xl text-indigo-100 mb-8 leading-relaxed">
                        {{ $service->hero_subtitle }}
                    </p>
                @endif

                @if($service->hero_cta_text && $service->hero_cta_link)
                    <a href="{{ $service->hero_cta_link }}" 
                        class="inline-block bg-white text-indigo-600 font-bold text-lg py-4 px-8 rounded-lg hover:bg-gray-100 transition shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        {{ $service->hero_cta_text }} →
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Features/Benefits Section --}}
    @if(count($service->features_array) > 0)
        <div class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-4xl font-bold text-center text-gray-900 mb-12">¿Por qué elegirnos?</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($service->features_array as $feature)
                        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-shadow border border-gray-100">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-700 text-lg">{{ $feature }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Description Section --}}
    @if($service->description)
        <div class="py-20">
            <div class="max-w-4xl mx-auto px-6">
                <div class="prose prose-lg max-w-none">
                    {!! nl2br(e($service->description)) !!}
                </div>
            </div>
        </div>
    @endif

    {{-- Testimonials Section --}}
    @if($service->testimonials->count() > 0)
        <div class="py-20 bg-gradient-to-br from-gray-50 to-indigo-50">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-4xl font-bold text-center text-gray-900 mb-4">Lo que dicen nuestros clientes</h2>
                <p class="text-center text-gray-600 mb-12 text-lg">Testimonios reales de clientes satisfechos</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($service->testimonials as $testimonial)
                        <div class="bg-white/80 backdrop-blur-sm p-8 rounded-2xl shadow-lg border border-gray-100">
                            {{-- Rating Stars --}}
                            <div class="flex text-yellow-400 mb-4">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $testimonial->rating ? 'fill-current' : 'text-gray-300 fill-current' }}" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>

                            {{-- Testimonial Text --}}
                            <p class="text-gray-700 mb-6 italic leading-relaxed">"{{ $testimonial->testimonial }}"</p>

                            {{-- Client Info --}}
                            <div class="flex items-center gap-4 border-t pt-4">
                                @if($testimonial->client_avatar)
                                    <img src="{{ Storage::disk('r2')->url($testimonial->client_avatar) }}" 
                                        alt="{{ $testimonial->client_name }}"
                                        class="w-12 h-12 rounded-full object-cover">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-lg">
                                        {{ substr($testimonial->client_name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="font-bold text-gray-900">{{ $testimonial->client_name }}</p>
                                    @if($testimonial->client_position || $testimonial->client_company)
                                        <p class="text-sm text-gray-600">
                                            {{ $testimonial->client_position }}
                                            @if($testimonial->client_position && $testimonial->client_company), @endif
                                            {{ $testimonial->client_company }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Pricing Section --}}
    @if($service->price)
        <div class="py-20">
            <div class="max-w-4xl mx-auto px-6">
                <div class="bg-gradient-to-br from-indigo-600 to-purple-600 text-white rounded-3xl shadow-2xl p-12 text-center">
                    <h2 class="text-4xl font-bold mb-4">Inversión</h2>
                    <div class="mb-6">
                        <span class="text-6xl font-bold">${{ number_format($service->price, 2) }}</span>
                        @if($service->price_description)
                            <span class="text-2xl text-indigo-100 ml-2">{{ $service->price_description }}</span>
                        @endif
                    </div>
                    @if($service->hero_cta_text && $service->hero_cta_link)
                        <a href="{{ $service->hero_cta_link }}" 
                            class="inline-block bg-white text-indigo-600 font-bold text-lg py-4 px-10 rounded-lg hover:bg-gray-100 transition shadow-lg">
                            {{ $service->hero_cta_text }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif

    {{-- Final CTA Section --}}
    <div class="relative py-24 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="relative max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">¿Listo para dar el siguiente paso?</h2>
            <p class="text-xl text-indigo-100 mb-10 max-w-2xl mx-auto">
                Contáctanos hoy y descubre cómo {{ $service->name }} puede transformar tu negocio
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#contacto" 
                    class="inline-block bg-white text-indigo-600 font-bold text-lg py-4 px-10 rounded-lg hover:bg-gray-100 transition shadow-lg">
                    Contáctanos Ahora
                </a>
                <a href="{{ route('services.index') }}" 
                    class="inline-block bg-transparent border-2 border-white text-white font-bold text-lg py-4 px-10 rounded-lg hover:bg-white hover:text-indigo-600 transition">
                    Ver Otros Servicios
                </a>
            </div>
        </div>
    </div>
</x-front-layout>
