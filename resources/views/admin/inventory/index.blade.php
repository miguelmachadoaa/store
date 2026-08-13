<x-app-layout>

{{-- ============================================================
     ZOLUM SHOP — GESTIÓN DE INVENTARIO
     Sistema visual: Brandbook Zolum (#FFFFFF + #131921 + #FFC933)
     ============================================================ --}}

<style>
@import url('https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@600;700&family=Orbitron:wght@700;800&family=DM+Sans:wght@400;500;600;700&display=swap');

:root {
    --bg-soft:        #F4F6F6;
    --navy:           #131921;
    --navy-light:     #1A2536;
    --orange:         #FFC933;
    --orange-hover:   #F3A847;
    --black:          #0F1111;
    --border:         #D5D9D9;
    --border-focus:   #E77600;
    --muted:          #555555;
    --red:            #B12704;
    --green:          #007600;
    --yellow:         #B8860B;
    --radius:         4px;
    --shadow:         0 1px 4px rgba(0,0,0,.07), 0 2px 14px rgba(0,0,0,.05);
    --font-display:   'Orbitron', sans-serif;
    --font-tech:      'Chakra Petch', sans-serif;
    --font-body:      'DM Sans', sans-serif;
}

.zin-page {
    background: var(--bg-soft);
    min-height: 85vh;
    padding: 24px 0 60px;
    font-family: var(--font-body);
    color: var(--black);
}

.zin-wrap {
    width: 100%;
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 16px;
}

/* ── METRICAS RÁPIDAS ──────────────────────────────────────── */
.zin-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.zin-stat-card {
    background: #FFFFFF;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 16px 20px;
    box-shadow: var(--shadow);
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.zin-stat-card__title {
    font-size: 11px;
    font-family: var(--font-tech);
    text-transform: uppercase;
    color: var(--muted);
    font-weight: 700;
}
.zin-stat-card__val {
    font-size: 22px;
    font-family: var(--font-display);
    font-weight: 800;
    color: var(--navy);
    margin-top: 4px;
}

/* ── PANEL Y FILTROS ───────────────────────────────────────── */
.zin-panel {
    background: #FFFFFF;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
}

.zin-header {
    background: var(--navy);
    padding: 16px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 3px solid var(--orange);
    flex-wrap: wrap;
    gap: 12px;
}
.zin-header__title {
    font-family: var(--font-display);
    font-size: 18px;
    font-weight: 800;
    color: #FFFFFF;
    text-transform: uppercase;
    margin: 0;
}
.zin-header__sub {
    font-family: var(--font-tech);
    font-size: 11px;
    color: #A2B2C8;
}

/* Barra de Filtros */
.zin-filters {
    padding: 20px 24px;
    background: #FAFAFA;
    border-bottom: 1px solid var(--border);
}
.zin-grid-filters {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 12px;
    align-items: end;
}
.zin-group { display: flex; flex-direction: column; }
.zin-label {
    font-size: 11px;
    font-weight: 700;
    color: var(--black);
    margin-bottom: 4px;
}
.zin-control {
    width: 100%;
    background: #FFFFFF;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 8px 10px;
    font-size: 12px;
    color: var(--black);
    outline: none;
    transition: all .15s;
}
.zin-control:focus {
    border-color: var(--border-focus);
    box-shadow: 0 0 3px rgba(228,121,17,0.5);
}

.zin-btn-filter {
    background: var(--navy);
    color: #FFFFFF;
    border: none;
    font-family: var(--font-tech);
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    padding: 9px 16px;
    border-radius: var(--radius);
    cursor: pointer;
    transition: background .15s;
    height: 36px;
}
.zin-btn-filter:hover { background: var(--navy-light); }

.zin-btn-export {
    background: var(--orange);
    color: var(--black);
    border: 1px solid #A88734;
    font-family: var(--font-tech);
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    padding: 9px 16px;
    border-radius: var(--radius);
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    height: 36px;
    transition: background .15s;
}
.zin-btn-export:hover { background: var(--orange-hover); }

/* ── TABLA DE PRODUCTOS ────────────────────────────────────── */
.zin-table-wrap { overflow-x: auto; }
.zin-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
    text-align: left;
}
.zin-table th {
    background: #EDF2F2;
    color: var(--black);
    font-family: var(--font-tech);
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .5px;
    padding: 12px 16px;
    border-bottom: 1px solid var(--border);
}
.zin-table td {
    padding: 12px 16px;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
}
.zin-table tbody tr:hover { background: #FFFBF5; }

/* Badges y elementos de tabla */
.zin-img {
    width: 42px;
    height: 42px;
    object-fit: cover;
    border-radius: var(--radius);
    border: 1px solid var(--border);
}
.zin-badge {
    display: inline-block;
    padding: 3px 8px;
    font-size: 10px;
    font-weight: 700;
    font-family: var(--font-tech);
    border-radius: 12px;
    text-transform: uppercase;
}
.zin-badge--green { background: #E6F4EA; color: var(--green); }
.zin-badge--yellow { background: #FEF7E0; color: var(--yellow); }
.zin-badge--red { background: #FCE8E6; color: var(--red); }
.zin-badge--gray { background: #E8EAED; color: var(--muted); }

.zin-price-main { font-weight: 700; color: var(--black); }
.zin-price-sub { font-size: 11px; color: var(--muted); }

.zin-pagination {
    padding: 16px 24px;
    background: #FFFFFF;
    border-top: 1px solid var(--border);
}

@media (max-width: 768px) {
    .zin-grid-filters { grid-template-columns: 1fr; }
}
</style>

<div class="zin-page">
    <div class="zin-wrap">

        {{-- ── TARJETAS DE MÉTRICAS RÁPIDAS ── --}}
        <div class="zin-stats">
            <div class="zin-stat-card">
                <div>
                    <div class="zin-stat-card__title">Total Unidades Stock</div>
                    <div class="zin-stat-card__val">{{ number_format($totalStockUnits) }}</div>
                </div>
                <span style="font-size: 24px;">📦</span>
            </div>
            <div class="zin-stat-card">
                <div>
                    <div class="zin-stat-card__title">Stock Bajo (1-5)</div>
                    <div class="zin-stat-card__val" style="color: var(--yellow);">{{ $lowStockCount }}</div>
                </div>
                <span style="font-size: 24px;">⚠️</span>
            </div>
            <div class="zin-stat-card">
                <div>
                    <div class="zin-stat-card__title">Agotados (0)</div>
                    <div class="zin-stat-card__val" style="color: var(--red);">{{ $outOfStockCount }}</div>
                </div>
                <span style="font-size: 24px;">🚫</span>
            </div>
            <div class="zin-stat-card">
                <div>
                    <div class="zin-stat-card__title">Tasa de Cambio</div>
                    <div class="zin-stat-card__val">Bs. {{ number_format($rate, 2) }}</div>
                </div>
                <span style="font-size: 24px;">💵</span>
            </div>
        </div>

        {{-- ── PANEL PRINCIPAL ── --}}
        <div class="zin-panel">
            
            {{-- Header del Panel --}}
            <div class="zin-header">
                <div>
                    <h2 class="zin-header__title">Inventario de Productos</h2>
                    <div class="zin-header__sub">Monitoreo y reporte de existencias en tiempo real</div>
                </div>
                <a href="{{ request()->fullUrlWithQuery(['export' => 'csv']) }}" class="zin-btn-export">
                    <span>📥</span> Exportar Filtrados (CSV)
                </a>
            </div>

            {{-- Formularios de Filtros --}}
            <div class="zin-filters">
                <form action="{{ url()->current() }}" method="GET" id="filter-form">
                    <div class="zin-grid-filters">
                        
                        {{-- Buscar por Nombre / SKU --}}
                        <div class="zin-group">
                            <label for="search" class="zin-label">Buscar Producto / SKU</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                placeholder="Ej: Samsung, SKU123..." class="zin-control">
                        </div>

                        {{-- Categoría --}}
                        <div class="zin-group">
                            <label for="category_id" class="zin-label">Categoría</label>
                            <select name="category_id" id="category_id" class="zin-control">
                                <option value="">-- Todas --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Marca --}}
                        <div class="zin-group">
                            <label for="brand_id" class="zin-label">Marca</label>
                            <select name="brand_id" id="brand_id" class="zin-control">
                                <option value="">-- Todas --</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Estado de Stock --}}
                        <div class="zin-group">
                            <label for="stock_status" class="zin-label">Estado Stock</label>
                            <select name="stock_status" id="stock_status" class="zin-control">
                                <option value="">-- Todos --</option>
                                <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>En Stock (>5)</option>
                                <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Stock Bajo (1-5)</option>
                                <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Agotados (0)</option>
                            </select>
                        </div>

                        {{-- Estatus --}}
                        <div class="zin-group">
                            <label for="is_active" class="zin-label">Estatus</label>
                            <select name="is_active" id="is_active" class="zin-control">
                                <option value="">-- Todos --</option>
                                <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>

                        {{-- Botones de Acción --}}
                        <div style="display: flex; gap: 8px;">
                            <button type="submit" class="zin-btn-filter" style="flex: 1;">Filtrar</button>
                            <a href="{{ url()->current() }}" class="zin-btn-filter" style="background: #6c757d; text-decoration: none; display: flex; align-items: center; justify-content: center;">Limpiar</a>
                        </div>

                    </div>
                </form>
            </div>

            {{-- Tabla de Productos --}}
            <div class="zin-table-wrap">
                <table class="zin-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>SKU</th>
                            <th>Categoría / Marca</th>
                            <th>Stock</th>
                            <th>Precios</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/42' }}" 
                                             alt="{{ $product->name }}" class="zin-img">
                                        <div>
                                            <strong style="color: var(--black); display: block;">{{ $product->name }}</strong>
                                            <span style="font-size: 11px; color: var(--muted);">ID: #{{ $product->id }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <code style="font-family: var(--font-tech); font-size: 12px; background: #EDF2F2; padding: 2px 6px; border-radius: 3px;">
                                        {{ $product->sku ?? 'N/A' }}
                                    </code>
                                </td>
                                <td>
                                    <div style="font-size: 12px;">{{ $product->category->name ?? 'Sin Cat.' }}</div>
                                    <div style="font-size: 11px; color: var(--muted);">{{ $product->brand->name ?? 'Sin Marca' }}</div>
                                </td>
                                <td>
                                    @if($product->stock <= 0)
                                        <span class="zin-badge zin-badge--red">Agotado (0)</span>
                                    @elseif($product->stock <= 5)
                                        <span class="zin-badge zin-badge--yellow">Bajo Stock ({{ $product->stock }})</span>
                                    @else
                                        <span class="zin-badge zin-badge--green">{{ $product->stock }} Unid.</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="zin-price-main">${{ number_format($product->price, 2) }}</div>
                                    <div class="zin-price-sub">Bs. {{ number_format($product->price_bs, 2) }}</div>
                                </td>
                                <td>
                                    @if($product->is_active)
                                        <span class="zin-badge zin-badge--green">Activo</span>
                                    @else
                                        <span class="zin-badge zin-badge--gray">Inactivo</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 32px; color: var(--muted);">
                                    No se encontraron productos que coincidan con los filtros aplicados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            <div class="zin-pagination">
                {{ $products->links() }}
            </div>

        </div>{{-- /zin-panel --}}

    </div>{{-- /zin-wrap --}}
</div>{{-- /zin-page --}}

</x-app-layout>