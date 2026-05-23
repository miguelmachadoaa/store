<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Nuevo Artículo</h2>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow rounded-lg p-6 border text-gray-900">

            <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data" id="postForm">
                @csrf

                {{-- Título --}}
                <div class="mb-4">
                    <label class="font-semibold text-gray-700 block mb-1">Título</label>
                    <input type="text" name="title" class="w-full border border-gray-300 rounded p-2 text-gray-900 focus:ring-1 focus:ring-indigo-500 focus:outline-none" required>
                </div>

                {{-- Imagen --}}
                <div class="mb-4">
                    <label class="font-semibold text-gray-700 block mb-1">Imagen destacada</label>
                    <input type="file" name="image" class="w-full border border-gray-300 rounded p-2 text-gray-900">
                </div>

                {{-- Extracto --}}
                <div class="mb-4">
                    <label class="font-semibold text-gray-700 block mb-1">Extracto</label>
                    <textarea name="excerpt" class="w-full border border-gray-300 rounded p-2 text-gray-900 focus:ring-1 focus:ring-indigo-500 focus:outline-none" rows="3"></textarea>
                </div>

                {{-- Contenido (TinyMCE) --}}
                <div class="mb-4">
                    <label class="font-semibold text-gray-700 block mb-1">Contenido</label>
                    {{-- Eliminamos 'required' nativo de HTML para evitar el bloqueo silencioso --}}
                    <textarea name="content" id="content_editor" class="w-full border border-gray-300 rounded p-2 text-gray-900" rows="8"></textarea>
                </div>

                {{-- Etiquetas --}}
                <div class="mb-4">
                    <label class="font-semibold text-gray-700 block mb-1">Etiquetas</label>
                    <div class="grid grid-cols-2 gap-2 mt-2 text-gray-800">
                        @foreach($tags as $tag)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                {{ $tag->name }}
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Estado --}}
                <div class="mb-4">
                    <label class="font-semibold text-gray-700 block mb-1">Estado</label>
                    <select name="is_published" class="w-full border border-gray-300 rounded p-2 text-gray-900 focus:ring-1 focus:ring-indigo-500 focus:outline-none">
                        <option value="0">Borrador</option>
                        <option value="1">Publicado</option>
                    </select>
                </div>

                {{-- Aseguramos el type="submit" explícito --}}
                <button type="submit" class="bg-indigo-600 text-white px-5 py-2.5 rounded font-medium hover:bg-indigo-700 transition duration-150">
                    Guardar Artículo
                </button>

            </form>

        </div>

    </div>

<script>
    tinymce.init({
        selector: '#content_editor',
        height: 450,
        plugins: 'link image media table lists code fullscreen',
        toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image media | table | code fullscreen',
        menubar: false,
        branding: false,
        // Forzamos al iframe a pintar el fondo blanco y el texto oscuro explícitamente, aislando estilos externos
        content_style: "body { font-family: Inter, sans-serif; font-size: 16px; color: #111827 !important; background-color: #ffffff !important; }",
        
        // Sincronización forzada antes del submit para que no falle ninguna validación backend
        setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave();
            });
        }
    });

    // Validación manual frontend antes de enviar para suplir el 'required' nativo
    document.getElementById('postForm').addEventListener('submit', function(e) {
        // Obliga a TinyMCE a volcar el contenido al textarea original antes de validar
        tinymce.triggerSave(); 
        
        const contentValue = document.getElementById('content_editor').value.trim();
        if (!contentValue) {
            e.preventDefault();
            alert('Por favor, ingresa el contenido del artículo.');
        }
    });
</script>

</x-app-layout>