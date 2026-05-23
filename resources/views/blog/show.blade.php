<x-front-layout>

<div class="max-w-4xl mx-auto py-12 px-4 min-h-screen bg-[#0d0e12] text-gray-300 relative font-sans">
    
    {{-- Grid técnico de fondo --}}
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#1f242e_1px,transparent_1px),linear-gradient(to_bottom,#1f242e_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-10 pointer-events-none"></div>

    <article class="relative z-10">
        
        {{-- Enlace de retorno --}}
        <div class="mb-6">
            <a href="{{ route('blog.index') }}" class="text-xs font-mono uppercase tracking-widest text-gray-500 hover:text-blue-400 transition flex items-center gap-2">
                <span>←</span> Return_To_Archive
            </a>
        </div>

        {{-- Encabezado de Metadata --}}
        <div class="font-mono text-[10px] text-gray-500 uppercase tracking-widest mb-3 flex items-center gap-4">
            <span>Timestamp: {{ $post->created_at->format('Y.m.d // H:i') }}</span>
            <span class="text-blue-500">|</span>
            <span>Author: Admin_System</span>
        </div>

        {{-- Título Principal --}}
        <h1 class="text-2xl md:text-4xl font-bold uppercase tracking-wide text-white mb-6 [font-family:'Orbitron',sans-serif] border-b border-[#262b36] pb-4 leading-tight">
            {{ $post->title }}
        </h1>

        {{-- Imagen Destacada de Alta Compresión Visual --}}
        @if($post->image)
            <div class="w-full overflow-hidden rounded-sm border border-[#262b36] mb-8 relative shadow-2xl">
                <div class="absolute inset-0 bg-blue-500/5 mix-blend-color z-10 pointer-events-none"></div>
                <img src="{{ asset('storage/' . $post->image) }}" 
                     class="w-full h-auto object-cover filter grayscale contrast-125">
            </div>
        @endif

        {{-- Tags / Módulos del Sistema --}}
        @if($post->tags->count() > 0)
            <div class="flex flex-wrap gap-2 mb-8 font-mono text-xs">
                @foreach($post->tags as $tag)
                    <a href="{{ route('blog.tag', $tag->slug) }}"
                       class="px-3 py-1 bg-[#14161d] border border-[#262b36] text-blue-400 hover:border-blue-500/50 hover:text-white transition duration-150 rounded-sm uppercase tracking-wider text-[11px]">
                        #{{ $tag->name }}
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Bloque de Contenido Inyectado (Soporta etiquetas de TinyMCE/CKEditor) --}}
        {{-- Forzamos estilos legibles dentro de la directiva de escape HTML --}}
        <div class="prose prose-invert max-w-none text-gray-300 font-mono text-xs md:text-sm leading-relaxed tracking-wide dynamic-content">
            {!! $post->content !!}
        </div>

    </article>
</div>

{{-- Estilos específicos para inyectar sobre el contenido dinámico del editor --}}
<style>
    .dynamic-content p { margin-bottom: 1.5rem; color: #9ca3af; text-align: justify; }
    .dynamic-content h2, .dynamic-content h3 { font-family: 'Orbitron', sans-serif; color: #ffffff !important; text-transform: uppercase; margin-top: 2rem; margin-bottom: 1rem; letter-spacing: 0.05em; }
    .dynamic-content h2 { font-size: 1.25rem; border-left: 2px solid #2563eb; padding-left: 0.5rem; }
    .dynamic-content h3 { font-size: 1.1rem; }
    .dynamic-content ul, .dynamic-content ol { margin-left: 1.25rem; margin-bottom: 1.5rem; list-style-type: square; color: #9ca3af; }
    .dynamic-content li { margin-bottom: 0.5rem; }
    .dynamic-content a { color: #3b82f6 !important; text-decoration: underline; }
    .dynamic-content a:hover { color: #60a5fa !important; }
    .dynamic-content blockquote { border-left: 3px solid #262b36; padding-left: 1rem; font-style: italic; color: #6b7280; background-color: #14161d; padding-top: 0.5rem; padding-bottom: 0.5rem; margin-bottom: 1.5rem; }
</style>

</x-front-layout>