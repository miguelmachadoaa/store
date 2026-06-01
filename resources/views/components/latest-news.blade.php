<section class="zolum-news-section">
    <div class="zolum-container">

        {{-- Encabezado de la sección --}}
        <div class="zolum-news-header">
            <div>
                <h2 class="zolum-news-title">
                    Tendencias & Estilo de Vida
                </h2>
                <p class="zolum-news-subtitle">
                    Tu estilo de vida, evolucionado.
                </p>
            </div>

            <a href="{{ route('blog.index') }}" class="zolum-news-link">
                Ver todo <span class="zolum-arrow">→</span>
            </a>
        </div>

        {{-- Grid de Artículos --}}
        <div class="zolum-news-grid">

            @foreach($posts as $post)
                <a href="{{ route('blog.show', $post->slug) }}" class="zolum-post-card">

                    {{-- Imagen Destacada limpia --}}
                    @if($post->image)
                        <div class="zolum-card-image-wrapper">
                            <img src="{{ asset('storage/' . $post->image) }}" 
                                 alt="{{ $post->title }}" 
                                 class="zolum-card-image">
                        </div>
                    @else
                        {{-- Placeholder limpio de la tienda --}}
                        <div class="zolum-card-placeholder">
                            <span class="zolum-placeholder-text">ZOLUM SHOP</span>
                        </div>
                    @endif

                    {{-- Cuerpo del Post --}}
                    <div class="zolum-card-body">
                        
                        <h3 class="zolum-card-title">
                            {{ $post->title }}
                        </h3>

                        <p class="zolum-card-excerpt">
                            {{ $post->excerpt }}
                        </p>

                        {{-- Footer del Post (Metadata) --}}
                        <div class="zolum-card-footer">
                            <span class="zolum-card-date">
                                {{ $post->created_at->format('d M, Y') }}
                            </span>
                            <span class="zolum-card-more">Leer artículo</span>
                        </div>
                    </div>

                </a>
            @endforeach

        </div>

    </div>
</section>