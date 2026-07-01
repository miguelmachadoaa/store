<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryAdminController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'required|boolean',
        ]);

        $data = [
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'is_active' => $validated['is_active'],
        ];

        // Guardar imagen en Cloudflare R2 si existe
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'r2');
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
                        ->with('success', 'Categoría creada exitosamente en Cloudflare R2!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'required|boolean',
        ]);

        $data = [
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'is_active' => $validated['is_active'],
        ];

        // Eliminar imagen de R2 si se marcó el checkbox
        if ($request->has('remove_image') && $category->image) {
            Storage::disk('r2')->delete($category->image);
            $data['image'] = null;
        }

        // Subir nueva imagen a Cloudflare R2
        if ($request->hasFile('image')) {
            // Eliminar imagen anterior de R2 si existe
            if ($category->image) {
                Storage::disk('r2')->delete($category->image);
            }
            
            $data['image'] = $request->file('image')->store('categories', 'r2');
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
                        ->with('success', 'Categoría actualizada exitosamente!');
    }

    public function destroy(Category $category)
    {
        // Eliminar imagen de Cloudflare R2 si existe antes de borrar el registro
        if ($category->image) {
            Storage::disk('r2')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
                        ->with('success', 'Categoría eliminada exitosamente por completo!');
    }
}