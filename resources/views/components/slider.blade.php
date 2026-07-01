<div class="relative w-full overflow-hidden">

    <div class="swiper mySwiper">
        <div class="swiper-wrapper">

            @foreach($sliders as $slider)
                <div class="swiper-slide">
                    <div class="relative">

                        {{-- Imagen --}}
                        <img src="{{ Storage::disk('r2')->url($slider->image) }}"
                             class="w-full h-[450px] object-cover rounded-lg shadow">

                        {{-- Texto --}}
                        <div class="absolute top-1/2 left-10 transform -translate-y-1/2 text-white max-w-lg">
                            <h2 class="text-4xl font-bold drop-shadow-lg">{{ $slider->title }}</h2>

                            @if($slider->subtitle)
                                <p class="mt-2 text-lg drop-shadow">{{ $slider->subtitle }}</p>
                            @endif

                            @if($slider->button_text)
                                <a href="{{ $slider->button_link }}"
                                   class="mt-4 inline-block bg-pink-600 hover:bg-pink-700 text-white px-6 py-2 rounded shadow">
                                    {{ $slider->button_text }}
                                </a>
                            @endif
                        </div>

                    </div>
                </div>
            @endforeach

        </div>

        {{-- Flechas --}}
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>

        {{-- Paginación --}}
        <div class="swiper-pagination"></div>
    </div>

</div>