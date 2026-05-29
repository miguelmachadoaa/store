<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Tax;
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
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
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
        ]);

        // Manejar la imagen
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        $product = Product::create($validated);

        $path = $validated['image'] ?? null;    

        $from = storage_path('app/public/' . $path);
                $to = public_path('storage/' . $path);

                if (!file_exists(dirname($to))) {
                    mkdir(dirname($to), 0775, true);
                }

                copy($from, $to);    

        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                ]);

                $from = storage_path('app/public/' . $path);
                $to = public_path('storage/' . $path);

                if (!file_exists(dirname($to))) {
                    mkdir(dirname($to), 0775, true);
                }

                copy($from, $to);    
            }
        }

        return redirect()->route('products.index')
            ->with('success', 'Producto creado exitosamente.');
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

        // Manejar la imagen
        if ($request->hasFile('image')) {
            // Eliminar imagen anterior
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        $product->update($validated);

        $path = $validated['image'] ?? $product->image;

        $from = storage_path('app/public/' . $path);
        $to = public_path('storage/' . $path);

        if (!file_exists(dirname($to))) {
            mkdir(dirname($to), 0775, true);
        }

        copy($from, $to);    

        $product->categories()->sync($request->categories ?? []);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                ]);

                $from = storage_path('app/public/' . $path);
                $to = public_path('storage/' . $path);

                if (!file_exists(dirname($to))) {
                    mkdir(dirname($to), 0775, true);
                }

                copy($from, $to);    


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
        // Eliminar imagen si existe
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }

    public function inlineUpdate(Request $request, Product $product)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'nullable',
            'image' => 'nullable|image|max:2048',
        ]);

        // Si es imagen
        if ($request->field === 'image' && $request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->update(['image' => $path]);

            return response()->json([
                'success' => true,
                'image_url' => asset('storage/'.$path),
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
        $query = Product::query()->where('is_active', 1);

        // Filtro por categoría
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        // Filtro por marca
        if ($request->brand) {
            $query->whereIn('brand_id', $request->brand);
        }

        // Filtro por precio
        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Ordenar
        if ($request->sort) {
            $query->orderBy('price', $request->sort === 'asc' ? 'ASC' : 'DESC');
        }

        // Mantenemos los filtros activos en la paginación con withQueryString()
        $products = $query->paginate(12)->withQueryString();

        // Si la petición es AJAX, devolvemos solo las tarjetas renderizadas
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

    public function byBrand(Request $request, $slug) // Añadimos Request $request aquí
    {
        $brand = Brand::where('slug', $slug)->firstOrFail();

        $products = Product::where('brand_id', $brand->id)
            ->where('is_active', 1)
            ->paginate(12);

        // Si la petición es AJAX (scroll infinito), devolvemos solo las tarjetas
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

    public function byCategory(Request $request, $slug) // Añadimos Request $request
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = Product::where('category_id', $category->id)
            ->where('is_active', 1)
            ->paginate(12);

        // Si la petición es AJAX, solo devolvemos las tarjetas renderizadas
        if ($request->ajax()) {
            $view = '';
            foreach ($products as $product) {
                // Renderizamos dinámicamente el componente de Blade
                $view .= view('components.product-card', compact('product'))->render();
            }
            return response()->json([
                'html' => $view,
                'nextPageUrl' => $products->nextPageUrl() // URL de la página que sigue (o null si es la última)
            ]);
        }

        $title = "Productos en {$category->name} - ".config('app.name');

        return view('shop.by-category', compact('category', 'products', 'title'));
    }

    public function detail($slug)
    {
        $product = Product::with(['brand', 'category'])->where('slug', $slug)->firstOrFail();

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(6)
            ->get();

        $relatedProducts = Product::where('brand_id', $product->brand_id)
            ->where('id', '!=', $product->id)
            ->take(6)
            ->get();

        return view('shop.detail', compact('product', 'related', 'relatedProducts'));
    }

    public function deleteImage(ProductImage $image)
    {
        // Eliminar del almacenamiento
        Storage::disk('public')->delete($image->image);

        // Eliminar de la base de datos
        $image->delete();

        return response()->json(['success' => true]);
    }
}
