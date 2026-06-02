<x-customer-layout>
    <div style="background-color: var(--bg-pure-white); border: 1px solid var(--border-gray); border-radius: 4px; box-shadow: 0 1px 4px rgba(0,0,0,.08); overflow: hidden; color: var(--carbon-black);">
        
        {{-- Barra de acento superior de la marca --}}
        <div style="height: 6px; width: 100%; background-color: var(--midnight-blue);"></div>

        <div style="padding: 2rem;">
            
            {{-- Encabezado de la Sección --}}
            <div style="margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid #E5E7EB;">
                <h2 class="zl-font-display" style="font-size: 22px; font-weight: 700; color: var(--midnight-blue); margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                    Mis Favoritos
                </h2>
                <p class="zl-font-technical" style="font-size: 11px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin: 0.25rem 0 0 0;">
                    Lista de deseos y productos guardados bajo supervisión
                </p>
            </div>

            @if($products->count())
                {{-- Grid Responsivo de Tarjetas de Producto --}}
                <div style="display: flex; flex-wrap: wrap; gap: 1.5rem;">
                    @foreach($products as $product)
                        <div class="product-wishlist-card" 
                             style="flex: 1 1 280px; max-width: calc(33.333% - 1rem); min-width: 260px; border: 1px solid var(--border-gray); border-radius: 4px; padding: 1.25rem; background-color: #FAFAFA; display: flex; flex-direction: column; justify-content: space-between; position: relative; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: all 0.2s;"
                             onmouseover="this.style.borderColor='var(--warm-orange)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.06)';" 
                             onmouseout="this.style.borderColor='var(--border-gray)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.02)';">
                            
                            {{-- Botón de Remover (Corazón Activo) --}}
                            <button onclick="toggleWishlist({{ $product->id }}, this)" 
                                    style="position: absolute; top: 12px; right: 12px; padding: 0.5rem; background-color: var(--bg-pure-white); border: 1px solid var(--border-gray); border-radius: 50%; color: var(--error-red); cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); z-index: 10; transition: background-color 0.2s;"
                                    onmouseover="this.style.backgroundColor='#FDF0ED';"
                                    onmouseout="this.style.backgroundColor='var(--bg-pure-white)';">
                                <svg style="width: 18px; height: 18px; fill: currentColor;" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                            </button>

                            {{-- Enlace e Información del Producto --}}
                            <a href="{{ route('product.detail', $product->slug) }}" style="text-decoration: none; color: inherit; display: flex; flex-direction: column; height: 100%;">
                                {{-- Contenedor de Imagen --}}
                                <div style="width: 100%; height: 180px; overflow: hidden; background-color: #FFFFFF; border: 1px solid #E5E7EB; border-radius: 4px; margin-bottom: 1rem; display: flex; align-items: center; justify-content: center;">
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/no-image.png') }}" 
                                         style="max-width: 100%; max-height: 100%; object-fit: contain; display: block;">
                                </div>
                                
                                {{-- Nombre del Producto --}}
                                <h3 style="font-size: 14px; font-weight: 700; color: var(--carbon-black); margin: 0 0 0.5rem 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 40px;">
                                    {{ $product->name }}
                                </h3>
                                
                                {{-- Bloque de Precios Multi-Moneda --}}
                                <div style="margin-top: auto; padding-bottom: 0.5rem;">
                                    <div class="zl-font-display" style="color: var(--midnight-blue); font-weight: 700; font-size: 18px; letter-spacing: -0.5px;">
                                        ${{ number_format($product->price, 2) }}
                                    </div>
                                    @if($product->total_bs)
                                        <div class="zl-font-technical" style="color: var(--text-muted); font-size: 11px; font-weight: 700; margin-top: 0.15rem; text-transform: uppercase;">
                                            Bs. {{ number_format($product->total_bs, 2) }}
                                        </div>
                                    @endif
                                </div>
                            </a>
                            
                            {{-- Botón de Acción Inline --}}
                            <div style="margin-top: 0.75rem;">
                                <button class="add-to-cart zl-font-technical" 
                                        data-id="{{ $product->id }}"
                                        style="width: 100%; background-color: var(--warm-orange); border: 1px solid var(--warm-orange-hover); color: var(--carbon-black); padding: 0.6rem 1rem; border-radius: 4px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; cursor: pointer; transition: background-color 0.2s;"
                                        onmouseover="this.style.backgroundColor='var(--warm-orange-hover)';"
                                        onmouseout="this.style.backgroundColor='var(--warm-orange)';">
                                    Agregar al Carrito
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Paginación Integrada --}}
                <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #E5E7EB;">
                    {{ $products->links() }}
                </div>
            @else
                {{-- Estado Vacío de Favoritos --}}
                <div style="text-align: center; padding: 4rem 2rem;">
                    <div style="font-size: 56px; line-height: 1; margin-bottom: 1rem; color: var(--border-gray); filter: grayscale(100%);">
                        ❤️
                    </div>
                    <p style="color: var(--text-muted); font-style: italic; font-size: 16px; margin: 0 0 1rem 0;">
                        Aún no tienes productos guardados en tu lista de deseos corporativa.
                    </p>
                    <a href="{{ route('shop.index') }}" 
                       class="zl-font-technical"
                       style="color: var(--text-link); font-size: 12px; font-weight: 700; text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px;"
                       onmouseover="this.style.textDecoration='underline'"
                       onmouseout="this.style.textDecoration='none'">
                        &larr; Explorar Catálogo de Productos
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        function toggleWishlist(productId, btn) {
            fetch(`/wishlist/toggle/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.status === 'removed') {
                    // Selecciona la tarjeta mediante la clase específica que le colocamos
                    const card = btn.closest('.product-wishlist-card');
                    if (card) {
                        card.remove();
                    }
                    
                    // Si ya no quedan tarjetas en pantalla, recarga para renderizar el bloque vacío (@else)
                    if (document.querySelectorAll('.product-wishlist-card').length === 0) {
                        location.reload();
                    }
                }
            });
        }
    </script>
</x-customer-layout>