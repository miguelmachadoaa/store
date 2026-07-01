<x-front-layout>

    <div class="max-w-7xl mx-auto py-12 px-6">

        <h1 class="text-3xl font-bold mb-6">
            Artículos con la etiqueta: {{ $tag->name }}
        </h1>

        @if($posts->count())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($posts as $post)
                    <a href="{{ route('blog.show', $post->slug) }}"
                       class="block bg-white shadow rounded overflow-hidden hover:shadow-lg transition">

                        @if($post->image)
                            <img src="{{ Storage::disk('r2')->url($post->image) }}"
                                 class="h-48 w-full object-cover">
                        @endif

                        <div class="p-4">
                            <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
                            <p class="text-gray-600 mt-2">{{ $post->excerpt }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $posts->links() }}
            </div>

        @else
            <p class="text-gray-600">No hay artículos con esta etiqueta.</p>
        @endif

    </div>

</x-front-layout>