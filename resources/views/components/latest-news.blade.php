<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">

        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Últimas Noticias</h2>

            <a href="{{ route('blog.index') }}"
               class="text-pink-600 hover:text-pink-700 font-semibold">
                Ver todas →
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            @foreach($posts as $post)
                <a href="{{ route('blog.show', $post->slug) }}"
                   class="bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition">

                    @if($post->image)
                        <img src="{{ Storage::disk('r2')->url($post->image) }}"
                             class="h-48 w-full object-cover">
                    @endif

                    <div class="p-5">
                        <h3 class="text-xl font-semibold text-gray-800">
                            {{ $post->title }}
                        </h3>

                        <p class="text-gray-600 mt-2">
                            {{ $post->excerpt }}
                        </p>

                        <div class="mt-4 text-sm text-gray-500">
                            {{ $post->created_at->format('d M, Y') }}
                        </div>
                    </div>

                </a>
            @endforeach

        </div>

    </div>
</section>