{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <priority>1.0</priority>
        <changefreq>daily</changefreq>
    </url>
    <url>
        <loc>{{ route('shop.index') }}</loc>
        <priority>0.9</priority>
        <changefreq>daily</changefreq>
    </url>
    <url>
        <loc>{{ route('blog.index') }}</loc>
        <priority>0.8</priority>
        <changefreq>daily</changefreq>
    </url>

    @foreach($products as $product)
        <url>
            <loc>{{ route('product.detail', $product->slug) }}</loc>
            <lastmod>{{ $product->updated_at->format('Y-m-d') }}</lastmod>
            <priority>0.8</priority>
            <changefreq>weekly</changefreq>
        </url>
    @endforeach

    @foreach($categories as $category)
        <url>
            <loc>{{ route('shop.byCategory', $category->slug) }}</loc>
            <priority>0.7</priority>
            <changefreq>weekly</changefreq>
        </url>
    @endforeach

    @foreach($brands as $brand)
        <url>
            <loc>{{ route('shop.byBrand', $brand->slug) }}</loc>
            <priority>0.6</priority>
            <changefreq>weekly</changefreq>
        </url>
    @endforeach
</urlset>