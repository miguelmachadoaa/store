<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('css')

    {{-- Forzamos a nivel de estilos internos que el admin ignore por completo el modo oscuro --}}
    <style>
        html, body {
            background-color: #f3f4f6 !important; /* bg-gray-100 */
            color: #1f2937 !important;            /* text-gray-800 */
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex">

        {{-- Sidebar --}}
        @if(auth()->user()->isAdmin())
            @include('layouts.sidebar')
        @endif

        {{-- Main content --}}
        <div class="flex-1 flex flex-col min-w-0 bg-gray-100">

            {{-- Top navigation --}}
            @include('layouts.navigation')

            {{-- Page Heading --}}
            @isset($header)
                <header class="bg-white shadow border-b border-gray-200">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- Page Content --}}
            <main class="p-6 flex-1 bg-gray-100">
                {{ $slot }}
            </main>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('js')
</body>
</html>