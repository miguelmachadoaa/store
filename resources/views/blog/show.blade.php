<x-front-layout>

<div class="max-w-4xl mx-auto py-12 px-6">

    <img src="{{ Storage::disk('r2')->url($post->image) }}" class="w-full rounded-lg shadow mb-6">

    <h1 class="text-4xl font-bold mb-4">{{ $post->title }}</h1>

    <div class="flex gap-2 mb-6">
        @foreach($post->tags as $tag)
            <a href="{{ route('blog.tag', $tag->slug) }}"
               class="px-3 py-1 bg-pink-100 text-pink-700 rounded-full text-sm">
                #{{ $tag->name }}
            </a>
        @endforeach
    </div>

    <div class="prose max-w-none">
        {!! $post->content !!}
    </div>

</div>

</x-front-layout>