<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings->store_name ?? 'Enlaces Oficiales' }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Inyección dinámica de la configuración del Administrador */
        body {
            @if($settings->linktree_bg_type === 'solid')
                background-color: {{ $settings->linktree_bg_color }};
            @elif($settings->linktree_bg_type === 'image' && $settings->linktree_bg_image)
                background-image: url('{{ Storage::disk('r2')->url($settings->linktree_bg_image) }}');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
            @else
                background: gradient(linear, to bottom, {{ $settings->linktree_bg_color }}, {{ $settings->linktree_bg_gradient_to }});
                background-image: linear-gradient(to bottom, {{ $settings->linktree_bg_color }}, {{ $settings->linktree_bg_gradient_to }});
            @endif
            color: #ffffff;
        }

        .custom-link-btn {
            background: {{ $settings->linktree_button_bg }};
            color: {{ $settings->linktree_button_text }};
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center px-4 py-12">

    <div class="text-center mb-8 w-full">
        <div class="w-24 h-24 bg-white rounded-full mx-auto mb-4 flex items-center justify-center overflow-hidden shadow-xl border-2 border-white/20">
            @if($settings->linktree_logo)
                <img src="{{ Storage::disk('r2')->url($settings->linktree_logo) }}" class="w-full h-full object-cover">
            @elseif($settings->store_logo)
                <img src="{{ Storage::disk('r2')->url($settings->store_logo) }}" class="w-full h-full object-cover">
            @else
                <span class="text-gray-800 font-black text-xl">{{ substr($settings->store_name ?? 'M', 0, 5) }}</span>
            @endif
        </div>
        <h1 class="text-xl font-bold tracking-wide text-white drop-shadow-md">{{ $settings->store_name ?? 'Agencia Maymi' }}</h1>
        <p class="text-sm text-white/80 mt-1 drop-shadow-sm">{{ $settings->store_slogan ?? 'Nuestros enlaces oficiales' }}</p>
    </div>

    <div class="w-full max-w-md space-y-4 z-10">
        @forelse($links as $link)
            <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer"
               class="custom-link-btn flex items-center justify-between border border-white/10 p-4 rounded-xl text-center font-medium transition duration-300 transform hover:-translate-y-0.5 shadow-lg group">
                <div class="w-8 text-left text-lg opacity-90 group-hover:scale-110 transition">
                    @if($link->icon)
                        <i class="{{ $link->icon }}"></i>
                    @else
                        <i class="fas fa-link"></i>
                    @endif
                </div>
                <span class="text-sm tracking-wide flex-1 pr-8 font-semibold">{{ $link->title }}</span>
            </a>
        @empty
            <p class="text-center text-sm opacity-60">No hay enlaces configurados todavía.</p>
        @endforelse
    </div>

    <div class="mt-auto pt-12 text-center z-10">
        <a href="{{ route('home') }}" class="text-xs opacity-60 hover:opacity-100 transition tracking-wider">
            &copy; {{ date('Y') }} - Volver al Sitio Principal
        </a>
    </div>

</body>
</html>