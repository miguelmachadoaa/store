<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Tax;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query()->withCount('favoritedBy');

        // Búsqueda
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        // Filtro por estado
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        $products = $query->latest()->paginate(10)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', 1)->get();
        $brands = Brand::where('is_active', 1)->get();
        $taxes = Tax::orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'brands', 'taxes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'tax_id' => 'nullable|exists:taxes,id',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'view_type' => 'nullable|string|in:default,hotmart',
            'landing_headline' => 'nullable|string|max:255',
            'landing_subheadline' => 'nullable|string|max:255',
            'landing_video_url' => 'nullable|url',
            'landing_benefits' => 'nullable|array',
            'landing_target_public' => 'nullable|array',
            'landing_testimonials' => 'nullable|array',
            'landing_bonuses' => 'nullable|array',
            'landing_warranty_days' => 'nullable|integer|min:0',
        ]);

        // Manejar la imagen destacada en Cloudflare R2
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'r2');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        $product = Product::create($validated);

        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        // Galería de imágenes múltiples en Cloudflare R2
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products', 'r2');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                ]);
            }
        }

        return redirect()->route('products.index')
            ->with('success', 'Producto creado exitosamente en Cloudflare R2.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $brands = Brand::where('is_active', 1)->get();
        $taxes = Tax::orderBy('name')->get();
        $categories = Category::where('is_active', 1)->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands', 'taxes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'tax_id' => 'nullable|exists:taxes,id',
            'sku' => 'nullable|string|unique:products,sku,'.$product->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        // Actualizar la imagen destacada en Cloudflare R2
        if ($request->hasFile('image')) {
            // Eliminar imagen anterior de R2
            if ($product->image) {
                Storage::disk('r2')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'r2');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        $product->update($validated);

        $product->categories()->sync($request->categories ?? []);

        // Añadir nuevas imágenes a la galería en Cloudflare R2
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products', 'r2');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                ]);
            }
        }

        return redirect()->route('products.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Eliminar imagen destacada de Cloudflare R2 si existe
        if ($product->image) {
            Storage::disk('r2')->delete($product->image);
        }

        // Eliminar también todas las imágenes de la galería asociadas a este producto en R2
        foreach ($product->images as $img) {
            Storage::disk('r2')->delete($img->image);
            $img->delete();
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Producto eliminado por completo.');
    }

    public function inlineUpdate(Request $request, Product $product)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'nullable',
            'image' => 'nullable|image|max:2048',
        ]);

        // Edición rápida de imagen desde la tabla (inline)
        if ($request->field === 'image' && $request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('r2')->delete($product->image);
            }

            $path = $request->file('image')->store('products', 'r2');
            $product->update(['image' => $path]);

            return response()->json([
                'success' => true,
                'image_url' => Storage::disk('r2')->url($path), // Retorna la URL pública de Cloudflare
            ]);
        }

        // Campos simples
        $product->update([
            $request->field => $request->value,
        ]);

        return response()->json(['success' => true]);
    }

    public function shop(Request $request)
{
    // 1. Iniciamos especificando que solo queremos los campos de products y valores únicos
    $query = Product::select('products.*')->distinct()->where('products.is_active', 1);

    // 2. Filtro por categoría (Adaptado por si usas la relación muchos a muchos)
    if ($request->category) {
        $query->whereHas('categories', function ($q) use ($request) {
            $q->where('categories.id', $request->category);
        });
        // NOTA: Si usas la columna directa de la tabla products, cámbialo a:
        // $query->where('products.category_id', $request->category);
    }

    // 3. Filtro por marca
    if ($request->brand) {
        // Asegúrate de que $request->brand sea un array para whereIn, si es un string usa where
        $brands = is_array($request->brand) ? $request->brand : [$request->brand];
        $query->whereIn('products.brand_id', $brands);
    }

    // 4. Filtro por precio (Especificando la tabla para evitar ambigüedades)
    if ($request->min_price) {
        $query->where('products.price', '>=', $request->min_price);
    }

    if ($request->max_price) {
        $query->where('products.price', '<=', $request->max_price);
    }

    // 5. Ordenar
    if ($request->sort) {
        $query->orderBy('products.price', $request->sort === 'asc' ? 'ASC' : 'DESC');
    } else {
        // Orden por defecto para que la paginación sea consistente en el scroll
        $query->latest('products.id');
    }

    $products = $query->paginate(100)->withQueryString();

    if ($request->ajax()) {
        $view = '';
        foreach ($products as $product) {
            $view .= view('components.product-card', compact('product'))->render();
        }
        return response()->json([
            'html' => $view,
            'nextPageUrl' => $products->nextPageUrl()
        ]);
    }

    $categories = Category::all();
    $brands = Brand::all();

    return view('shop.index', compact('products', 'categories', 'brands'));
}

    public function byBrand(Request $request, $slug)
    {
        $brand = Brand::where('slug', $slug)->firstOrFail();

        $products = Product::where('brand_id', $brand->id)
            ->where('is_active', 1)
            ->paginate(100);

        if ($request->ajax()) {
            $view = '';
            foreach ($products as $product) {
                $view .= view('components.product-card', compact('product'))->render();
            }
            return response()->json([
                'html' => $view,
                'nextPageUrl' => $products->nextPageUrl()
            ]);
        }

        $title = "Productos marca {$brand->name} - ".config('app.name');

        return view('shop.by-brand', compact('brand', 'products', 'title'));
    }

    public function byCategory(Request $request, $slug)
{
    $category = Category::where('slug', $slug)->firstOrFail();

    // CORRECCIÓN: Usamos select('products.*') para evitar que se pisen los IDs
    $products = Product::select('products.*') // Evita que se pisen los IDs
    ->join('category_product', 'products.id', '=', 'category_product.product_id')
    ->where('category_product.category_id', $category->id)
    ->where('products.is_active', 1)
    ->distinct() // CORRECCIÓN: Evita que se dupliquen productos si están repetidos en la tabla pivote
    ->paginate(100);// Aquí conservas tu paginación de 20 en 20

    if ($request->ajax()) {
        $view = '';
        foreach ($products as $product) {
            $view .= view('components.product-card', compact('product'))->render();
        }
        return response()->json([
            'html' => $view,
            'nextPageUrl' => $products->nextPageUrl()
        ]);
    }

    $title = "Productos en {$category->name} - " . config('app.name');

    return view('shop.by-category', compact('category', 'products', 'title'));
}

    public function detail($slug)
    {
        $product = Product::with(['brand', 'category'])->where('slug', $slug)->firstOrFail();

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(3)
            ->get();

        $relatedProducts = Product::where('brand_id', $product->brand_id)
            ->where('id', '!=', $product->id)
            ->take(3)
            ->get();

            $reviews = Review::where('product_id', $product->id)
            ->where('is_approved', true)
            ->with(['user', 'images']) // <--- Carga eager loading
            ->get();

        return view('shop.detail', compact('product', 'related', 'relatedProducts'));
    }

    public function deleteImage(ProductImage $image)
    {
        // Eliminar del almacenamiento de Cloudflare R2
        Storage::disk('r2')->delete($image->image);

        // Eliminar de la base de datos
        $image->delete();

        return response()->json(['success' => true]);
    }
}