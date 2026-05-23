<x-front-layout>

<div class="max-w-7xl mx-auto py-12 px-6 min-h-screen bg-[#0d0e12] text-gray-300 relative font-sans">
    
    {{-- Grid técnico de fondo --}}
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#1f242e_1px,transparent_1px),linear-gradient(to_bottom,#1f242e_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-10 pointer-events-none"></div>

    {{-- Encabezado del Blog --}}
    <div class="border-b border-[#262b36] pb-6 mb-10 relative z-10">
        <h1 class="text-3xl font-bold uppercase tracking-wider text-white [font-family:'Orbitron',sans-serif]">
            Technical_Archive / Blog
        </h1>
        <p class="text-xs text-gray-500 uppercase tracking-widest font-mono mt-1">
            Index of published articles, teardowns and documentation
        </p>
    </div>

    {{-- Grid de Artículos --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
        @foreach($posts as $post)
            <a href="{{ route('blog.show', $post->slug) }}" 
               class="flex flex-col bg-[#14161d] border border-[#262b36] rounded-sm overflow-hidden hover:border-blue-500/50 transition duration-200 group h-full shadow-2xl">
                
                {{-- Contenedor de Imagen con Filtro --}}
                @if($post->image)
                    <div class="h-48 w-full overflow-hidden relative border-b border-[#262b36]">
                        <div class="absolute inset-0 bg-blue-500/5 mix-blend-color z-10 pointer-events-none"></div>
                        <img src="{{ asset('storage/' . $post->image) }}" 
                             class="h-full w-full object-cover filter grayscale contrast-125 group-hover:scale-105 transition duration-300">
                    </div>
                @else
                    {{-- Placeholder por si el post no tiene imagen --}}
                    <div class="h-48 w-full bg-[#1b1e26] border-b border-[#262b36] flex items-center justify-center font-mono text-[10px] text-gray-600 uppercase tracking-widest">
                        Null_Image_Asset
                    </div>
                @endif

                {{-- Cuerpo del Post --}}
                <div class="p-5 flex flex-col flex-1">
                    <span class="text-[9px] font-mono text-blue-500 uppercase tracking-widest mb-2 block">
                        Log_File // {{ $post->created_at->format('Y.m.d') }}
                    </span>

                    <h2 class="text-lg font-bold text-white uppercase tracking-wide group-hover:text-blue-400 transition duration-150 line-clamp-2 [font-family:'Orbitron',sans-serif]">
                        {{ $post->title }}
                    </h2>

                    <p class="text-xs text-gray-400 font-mono mt-3 line-clamp-4 leading-relaxed flex-1">
                        {{ $post->excerpt }}
                    </p>

                    {{-- Footer metadata interna --}}
                    <div class="mt-6 pt-3 border-t border-[#1f242e] flex items-center justify-between font-mono text-[10px] text-gray-500 uppercase tracking-wider">
                        <span>Status: <span class="text-emerald-500">Readable</span></span>
                        <span class="text-blue-500 font-bold group-hover:underline">[Execute]</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    {{-- Contenedor de Paginación --}}
    <div class="mt-12 pt-6 border-t border-[#262b36] relative z-10 font-mono text-xs text-gray-400 pagination-dark">
        {{ $posts->links() }}
    </div>
</div>

{{-- Estilos rápidos para forzar a los botones de paginación nativos de Tailwind (si usas los de Breeze) a verse oscuros --}}
<style>
    .pagination-dark nav svg { fill: #9ca3af; }
    .pagination-dark nav [aria-current="page"] span { background-color: #2563eb !important; border-color: #2563eb !important; color: white !important; }
    .pagination-dark nav a, .pagination-dark nav span { background-color: #14161d !important; border-color: #262b36 !important; color: #9ca3af !important; border-radius: 2px !important; }
    .pagination-dark nav a:hover { border-color: #3b82f6 !important; color: white !important; }
</style>

</x-front-layout>