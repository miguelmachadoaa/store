<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-gray-100 flex">

        {{-- Sidebar --}}
        @if(auth()->user()->isAdmin())
            @include('layouts.sidebar')
        @endif

        {{-- Main content --}}
        <div class="flex-1">

            {{-- Top navigation --}}
            @include('layouts.navigation')

            {{-- Page Heading --}}
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- Page Content --}}
            <main class="p-6">
                {{ $slot }}
            </main>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('textarea[name="content"]'), {
                toolbar: [
                    'undo', 'redo', '|',
                    'heading', '|',
                    'bold', 'italic', 'underline', '|',
                    'bulletedList', 'numberedList', '|',
                    'link', 'insertTable', '|',
                    'blockQuote', 'codeBlock'
                ]
            })
            .catch(error => {
                console.error(error);
            });
    </script>

     <!-- Script para autocompletar campos SEO -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nameInput = document.getElementById('name');
            const descriptionInput = document.getElementById('description');
            const metaTitleInput = document.getElementById('meta_title');
            const metaDescriptionInput = document.getElementById('meta_description');

            // Banderas para saber si el usuario ha editado manualmente los campos SEO
            let metaTitleEdited = false;
            let metaDescriptionEdited = false;

            // Detectar si el usuario escribe directamente en Meta Title
            metaTitleInput.addEventListener('input', () => {
                metaTitleEdited = true;
                if (metaTitleInput.value.trim() === "") metaTitleEdited = false; // Si lo borra todo, vuelve a automatizarse
            });

            // Detectar si el usuario escribe directamente en Meta Description
            metaDescriptionInput.addEventListener('input', () => {
                metaDescriptionEdited = true;
                if (metaDescriptionInput.value.trim() === "") metaDescriptionEdited = false;
            });

            // Escuchar el tipeo en el nombre del producto
            nameInput.addEventListener('input', () => {
                if (!metaTitleEdited) {
                    metaTitleInput.value = nameInput.value;
                }
            });

            // Escuchar el tipeo en la descripción del producto
            descriptionInput.addEventListener('input', () => {
                if (!metaDescriptionEdited) {
                    // Copia el texto y opcionalmente limita los caracteres para SEO (ej: 160 caracteres)
                    metaDescriptionInput.value = descriptionInput.value.substring(0, 160);
                }
            });
        });
    </script>

</body>

</html>