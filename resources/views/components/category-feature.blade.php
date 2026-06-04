{{-- Contenedor Principal Unificado para la Categoría Actual --}}
<div class="category-view-wrapper" style="display: flex; flex-direction: column; gap: 40px; margin-bottom: 40px;">

    <section class="products-section products-section--alt" style="padding-top: 10px;">
        <div class="products-section__inner">
            <p class="section-eyebrow">Catálogo Disponible</p>
            <h2 class="section-title">Explora nuestra selección de <em>{{ $category->name }}</em></h2>
            

            @if($category->children && $category->children->count() > 0)

                <div class="cat-grid mb-4" >
                    @foreach($category->children as $subcategory)
                        <a href="{{ route('shop.byCategory', $subcategory->slug) }}" class="cat-card">
                            <div class="cat-card__img">
                                @if($subcategory->image)
                                    <img src="{{ asset('storage/' . $subcategory->image) }}" alt="{{ $subcategory->name }}">
                                @else
                                    {{-- Icono/Emoji industrial de respaldo para subcategorías --}}
                                    <div class="cat-card__placeholder">🛠️</div>
                                @endif
                            </div>
                            <div class="cat-card__label">
                                {{ $subcategory->name }}
                                <span>→</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif


            @if($category->products && $category->products->count() > 0)
                {{-- Implementación de la nueva clase "products-grid-6" --}}
                <div class="products-grid-4 mt-4">
                    @foreach($category->products->take(8) as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            @else
                {{-- Estado vacío si esta categoría en específico no tiene productos aún --}}
                <div class="ap-catalog__empty" style="margin-top: 20px;">
                    <div class="ap-catalog__empty-icon">📦</div>
                    <h3 class="ap-catalog__empty-title">Sin productos</h3>
                    <p class="ap-catalog__empty-text">Pronto añadiremos nuevos artículos a la sección de {{ $category->name }}.</p>
                </div>
            @endif

            
        </div>
    </section>

</div>