<x-front-layout>

<div style="background-color: var(--bg-pure-white); min-height: 100vh; padding: 3rem 1.5rem; color: var(--carbon-black); box-sizing: border-box;">
    <div style="max-width: 800px; margin: 0 auto;">
        
        {{-- Botón Volver --}}
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('blog.index') }}" 
               class="zl-font-technical" 
               style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted); text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; font-weight: 600;"
               onmouseover="this.style.color='var(--warm-orange)';" 
               onmouseout="this.style.color='var(--text-muted)';">
                ← Volver al archivo técnico
            </a>
        </div>

        {{-- Info de Publicación --}}
        <div class="zl-font-technical" style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 1rem; font-weight: 600;">
            <span>Fecha: {{ $post->created_at->format('d/m/Y // H:i') }}</span>
            <span style="color: var(--border-gray);">|</span>
            <span>Autor: Soporte Técnico Zolum</span>
        </div>

        {{-- Título --}}
        <h1 class="zl-font-display" style="font-size: 32px; font-weight: 700; color: var(--midnight-blue); text-transform: uppercase; letter-spacing: 0.3px; line-height: 1.25; margin: 0 0 1.5rem 0; padding-bottom: 1.25rem; border-bottom: 1px solid var(--border-gray);">
            {{ $post->title }}
        </h1>

        {{-- Imagen Principal --}}
        @if($post->image)
            <div style="width: 100%; overflow: hidden; border: 1px solid var(--border-gray); border-radius: 4px; margin-bottom: 2.5rem; background-color: #FAFAFA; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                <img src="{{ asset('storage/' . $post->image) }}" style="width: 100%; height: auto; display: block;">
            </div>
        @endif

        {{-- Etiquetas / Tags --}}
        @if($post->tags->count() > 0)
            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 2.5rem;">
                @foreach($post->tags as $tag)
                    <a href="{{ route('blog.tag', $tag->slug) }}"
                       class="zl-font-technical"
                       style="padding: 0.35rem 0.75rem; background-color: #FAFAFA; border: 1px solid var(--border-gray); text-decoration: none; color: var(--carbon-black); border-radius: 4px; text-transform: uppercase; letter-spacing: 0.5px; font-size: 10px; font-weight: 700; transition: all 0.2s;"
                       onmouseover="this.style.borderColor='var(--warm-orange)'; this.style.color='var(--warm-orange)';" 
                       onmouseout="this.style.borderColor='var(--border-gray)'; this.style.color='var(--carbon-black)';"
                    >
                        #{{ $tag->name }}
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Bloque de Contenido Dinámico --}}
        <div class="dynamic-blog-content" style="color: #374151; font-size: 15px; line-height: 1.75; text-align: left;">
            {!! $post->content !!}
        </div>

    </div>
</div>

{{-- Estilos encapsulados para el contenido inyectado por el editor --}}
<style>
    .dynamic-blog-content p { 
        margin: 0 0 1.5rem 0; 
        color: #374151; 
    }
    .dynamic-blog-content h2, 
    .dynamic-blog-content h3 { 
        font-family: var(--font-display), sans-serif; 
        color: var(--midnight-blue) !important; 
        text-transform: uppercase; 
        margin-top: 2.5rem; 
        margin-bottom: 1rem; 
        letter-spacing: 0.3px; 
        font-weight: 700;
    }
    .dynamic-blog-content h2 { 
        font-size: 20px; 
        border-left: 3px solid var(--warm-orange); 
        padding-left: 0.75rem; 
    }
    .dynamic-blog-content h3 { 
        font-size: 16px; 
    }
    .dynamic-blog-content ul, 
    .dynamic-blog-content ol { 
        margin: 0 0 1.5rem 1.5rem; 
        padding: 0;
        color: #374151; 
    }
    .dynamic-blog-content ul {
        list-style-type: disc;
    }
    .dynamic-blog-content li { 
        margin-bottom: 0.5rem; 
    }
    .dynamic-blog-content a { 
        color: var(--warm-orange) !important; 
        text-decoration: underline; 
        font-weight: 600;
    }
    .dynamic-blog-content a:hover { 
        color: var(--midnight-blue) !important; 
    }
    .dynamic-blog-content blockquote { 
        border-left: 3px solid var(--midnight-blue); 
        padding: 1rem 1.25rem;
        margin: 0 0 1.5rem 0;
        font-style: italic; 
        color: #4B5563; 
        background-color: #F9FAFB; 
        border-radius: 0 4px 4px 0;
    }
    .dynamic-blog-content strong {
        color: var(--carbon-black);
        font-weight: 700;
    }
</style>

</x-front-layout>