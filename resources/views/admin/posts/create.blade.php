<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Nuevo Artículo</h2>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto sm:px-6 lg:px-8">

        {{-- Alertas de error globales por si falta algo --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow rounded-lg p-6 border">
            <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Título --}}
                <div class="mb-4">
                    <label class="font-semibold block mb-1">Título</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded p-2 focus:ring focus:ring-indigo-200" required>
                </div>

                {{-- Imagen --}}
                <div class="mb-4">
                    <label class="font-semibold block mb-1">Imagen destacada</label>
                    <input type="file" name="image" class="w-full border rounded p-2">
                </div>

                {{-- Extracto --}}
                <div class="mb-4">
                    <label class="font-semibold block mb-1">Extracto</label>
                    <textarea name="excerpt" class="w-full border rounded p-2" rows="3">{{ old('excerpt') }}</textarea>
                </div>

                {{-- Contenido (Quitamos 'required' para evitar el bug visual de TinyMCE) --}}
                <div class="mb-4">
                    <label class="font-semibold block mb-1">Contenido</label>
                    <textarea id="post-content" name="content" class="w-full border rounded p-2" rows="8">{{ old('content') }}</textarea>
                </div>

                {{-- Etiquetas --}}
                <div class="mb-4">
                    <label class="font-semibold block mb-1">Etiquetas</label>
                    @if(isset($tags) && $tags->count() > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 mt-2 p-3 bg-gray-50 rounded border">
                            @foreach($tags as $tag)
                                <label class="flex items-center gap-2 cursor-pointer p-1 hover:bg-gray-100 rounded text-sm">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" 
                                        {{ is_array(old('tags')) && in_array($tag->id, old('tags')) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <span>{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-gray-500 italic mt-1">No hay etiquetas creadas en el sistema.</p>
                    @endif
                </div>

                {{-- Estado --}}
                <div class="mb-4">
                    <label class="font-semibold block mb-1">Estado</label>
                    <select name="is_published" class="w-full border rounded p-2">
                        <option value="0" {{ old('is_published') == '0' ? 'selected' : '' }}>Borrador</option>
                        <option value="1" {{ old('is_published') == '1' ? 'selected' : '' }}>Publicado</option>
                    </select>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded font-medium hover:bg-indigo-700 transition">
                        Guardar Artículo
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script optimizado (usando ID en vez de selector name para evitar conflictos) --}}
    <script>
        tinymce.init({
            selector: '#post-content',
            height: 450,
            plugins: 'link image media table lists code fullscreen',
            toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image media | table | code fullscreen',
            menubar: false,
            branding: false,
            content_style: "body { font-family:Inter, sans-serif; font-size:16px; }",
            setup: function (editor) {
                // Esto fuerza a TinyMCE a guardar el contenido en el textarea real antes de enviar el formulario
                editor.on('change', function () {
                    editor.save();
                });
            }
        });
    </script>
</x-app-layout>