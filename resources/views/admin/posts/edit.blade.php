<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Editar Artículo</h2>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow rounded-lg p-6 border">

            <form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Título --}}
                <div class="mb-4">
                    <label class="font-semibold">Título</label>
                    <input type="text" name="title" value="{{ $post->title }}" class="w-full border rounded p-2" required>
                </div>

                {{-- Imagen actual --}}
                @if($post->image)
                    <div class="mb-4">
                        <p class="font-semibold">Imagen actual:</p>
                        <img src="{{ Storage::disk('r2')->url($post->image) }}" class="h-32 rounded shadow">
                    </div>
                @endif

                {{-- Nueva imagen --}}
                <div class="mb-4">
                    <label class="font-semibold">Cambiar imagen</label>
                    <input type="file" name="image" class="w-full border rounded p-2">
                </div>

                {{-- Extracto --}}
                <div class="mb-4">
                    <label class="font-semibold">Extracto</label>
                    <textarea name="excerpt" class="w-full border rounded p-2" rows="3">{{ $post->excerpt }}</textarea>
                </div>

                {{-- Contenido --}}
                <div class="mb-4">
                    <label class="font-semibold">Contenido</label>
                    <textarea name="content" class="w-full border rounded p-2" rows="8" required>{{ $post->content }}</textarea>
                </div>

                {{-- Etiquetas --}}
                <div class="mb-4">
                    <label class="font-semibold">Etiquetas</label>
                    <div class="grid grid-cols-2 gap-2 mt-2">
                        @foreach($tags as $tag)
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                       {{ $post->tags->contains($tag->id) ? 'checked' : '' }}>
                                {{ $tag->name }}
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Estado --}}
                <div class="mb-4">
                    <label class="font-semibold">Estado</label>
                    <select name="is_published" class="w-full border rounded p-2">
                        <option value="0" {{ !$post->is_published ? 'selected' : '' }}>Borrador</option>
                        <option value="1" {{ $post->is_published ? 'selected' : '' }}>Publicado</option>
                    </select>
                </div>

                <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    Actualizar Artículo
                </button>

            </form>

        </div>

    </div>
<script>
    tinymce.init({
        selector: 'textarea[name="content"]',
        height: 450,
        plugins: 'link image media table lists code fullscreen',
        toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image media | table | code fullscreen',
        menubar: false,
        branding: false,
        content_style: "body { font-family:Inter, sans-serif; font-size:16px; }"
    });
</script>

</x-app-layout>