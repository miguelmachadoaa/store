<x-front-layout>

<div style="background-color: var(--bg-pure-white); min-height: 100vh; padding: 3rem 1.5rem; color: var(--carbon-black); box-sizing: border-box;">
    <div style="max-width: 1200px; margin: 0 auto;">

        {{-- Encabezado del Filtro por Etiqueta (Estilo institucional) --}}
        <div style="margin-bottom: 3rem; text-align: left; border-bottom: 1px solid var(--border-gray); padding-bottom: 1.5rem;">
            <p class="zl-font-technical" style="font-size: 11px; color: var(--warm-orange); font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 0.5rem 0;">
                Filtrado por etiqueta
            </p>
            <h1 class="zl-font-display" style="font-size: 28px; font-weight: 700; color: var(--midnight-blue); margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                Artículos con la etiqueta: <span style="font-style: italic; font-weight: 400; text-transform: lowercase; color: var(--warm-orange);">#{{ $tag->name }}</span>
            </h1>
        </div>

        @if($posts->count())
            {{-- Grid de Artículos --}}
            <div style="display: flex; flex-wrap: wrap; gap: 2rem;">
                @foreach($posts as $post)
                    <a href="{{ route('blog.show', $post->slug) }}" 
                       class="blog-clean-card"
                       style="flex: 1 1 320px; max-width: calc(33.333% - 1.35rem); min-width: 290px; display: flex; flex-direction: column; background-color: #FFFFFF; border: 1px solid var(--border-gray); border-radius: 4px; overflow: hidden; text-decoration: none; color: inherit; box-shadow: 0 2px 8px rgba(0,0,0,0.04); transition: all 0.2s;"
                       onmouseover="this.style.borderColor='var(--warm-orange)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)';" 
                       onmouseout="this.style.borderColor='var(--border-gray)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.04)';"
                    >

                        {{-- Imagen del Post --}}
                        @if($post->image)
                            <div style="height: 200px; width: 100%; overflow: hidden; background-color: #FAFAFA; border-bottom: 1px solid var(--border-gray);">
                                <img src="{{ asset('storage/' . $post->image) }}" 
                                     style="height: 100%; width: 100%; object-fit: cover; transition: transform 0.3s;"
                                     onmouseover="this.style.transform='scale(1.02)'"
                                     onmouseout="this.style.transform='scale(1)'">
                            </div>
                        @else
                            {{-- Placeholder --}}
                            <div class="zl-font-technical" style="height: 200px; width: 100%; background-color: #F3F4F6; border-bottom: 1px solid var(--border-gray); display: flex; align-items: center; justify-content: center; font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">
                                ⚙️ Sin imagen de registro
                            </div>
                        @endif

                        {{-- Cuerpo de la tarjeta --}}
                        <div style="padding: 1.5rem; display: flex; flex-direction: column; flex: 1;">
                            <span class="zl-font-technical" style="text-transform: uppercase; font-size: 10px; color: var(--text-muted); font-weight: 600; letter-spacing: 0.5px; margin-bottom: 0.5rem; display: block;">
                                Publicado // {{ $post->created_at->format('d.m.Y') }}
                            </span>

                            <h2 class="zl-font-display" style="font-size: 16px; font-weight: 700; color: var(--midnight-blue); text-transform: uppercase; letter-spacing: 0.3px; line-height: 1.4; margin: 0 0 0.75rem 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 44px;">
                                {{ $post->title }}
                            </h2>

                            <p style="font-size: 13px; color: #556173; margin: 0; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; flex: 1; text-align: left;">
                                {{ $post->excerpt }}
                            </p>

                            {{-- Footer de la tarjeta --}}
                            <div style="margin-top: auto; padding-top: 1rem; border-top: 1px solid var(--border-gray); display: flex; align-items: center; justify-content: space-between;">
                                <span class="zl-font-technical" style="font-size: 10px; text-transform: uppercase; color: var(--text-muted); font-weight: 600;">
                                    Estado: <span style="color: var(--success-green);">Disponible</span>
                                </span>
                                <span class="zl-font-technical" style="font-size: 11px; text-transform: uppercase; color: var(--warm-orange); font-weight: 700; display: inline-flex; align-items: center; gap: 2px;">
                                    Leer artículo <span style="font-size: 12px;">→</span>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Paginación Limpia --}}
            <div class="pagination-clean-container" style="margin-top: 4rem; padding-top: 1.5rem; border-top: 1px solid var(--border-gray);">
                {{ $posts->links() }}
            </div>

        @else
            {{-- Bloque Vacío Institucional --}}
            <div style="text-align: center; padding: 4rem 1.5rem; border: 1px dashed var(--border-gray); border-radius: 4px; background-color: #FAFAFA;">
                <p class="zl-font-display" style="font-size: 16px; color: var(--midnight-blue); font-weight: 700; text-transform: uppercase; margin: 0 0 0.5rem 0;">
                    Sin registros coincidentes
                </p>
                <p style="font-size: 14px; color: var(--text-muted); margin: 0 0 1.5rem 0;">
                    No se han encontrado artículos asociados a la etiqueta solicitada en este momento.
                </p>
                <a href="{{ route('blog.index') }}" 
                   class="zl-font-technical"
                   style="display: inline-block; padding: 0.6rem 1.2rem; background-color: var(--midnight-blue); color: #FFFFFF; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; transition: background-color 0.2s;"
                   onmouseover="this.style.backgroundColor='var(--warm-orange)';"
                   onmouseout="this.style.backgroundColor='var(--midnight-blue)';"
                >
                    Volver al índice completo
                </a>
            </div>
        @endif

    </div>
</div>

{{-- Estilos para forzar la estética limpia en los elementos de paginación de Laravel --}}
<style>
    .pagination-clean-container nav svg { 
        fill: var(--carbon-black) !important; 
    }
    .pagination-clean-container nav [aria-current="page"] span { 
        background-color: var(--midnight-blue) !important; 
        border-color: var(--midnight-blue) !important; 
        color: #FFFFFF !important; 
        font-weight: 700 !important;
    }
    .pagination-clean-container nav a, 
    .pagination-clean-container nav span { 
        background-color: #FFFFFF !important; 
        border-color: var(--border-gray) !important; 
        color: var(--carbon-black) !important; 
        border-radius: 4px !important; 
        font-size: 12px;
    }
    .pagination-clean-container nav a:hover { 
        border-color: var(--warm-orange) !important; 
        color: var(--warm-orange) !important; 
    }
</style>

</x-front-layout>