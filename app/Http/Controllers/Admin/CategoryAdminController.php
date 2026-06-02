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
        // Usamos with('parent') para evitar el problema de consultas N+1 al mostrar el nombre del padre en el listado
        $categories = Category::with('parent')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        // Obtenemos solo las categorías raíz para poder asignarlas como padres en el formulario
        $parentCategories = Category::onlyParents()->get();
        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'required|boolean',
            'is_featured' => 'required|boolean', // Validación del nuevo campo
            'parent_id' => 'nullable|exists:categories,id', // Debe existir en la tabla
        ]);

        $data = [
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'is_active' => $validated['is_active'],
            'is_featured' => $validated['is_featured'],
            'parent_id' => $validated['parent_id'],
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        

        Category::create($data);

        $path = $data['image'];
        $from = storage_path('app/public/' . $path);
        $to = public_path('storage/' . $path);

        if (!file_exists(dirname($to))) {
            mkdir(dirname($to), 0775, true);
        }

        copy($from, $to);

        return redirect()->route('admin.categories.index')
                         ->with('success', '¡Categoría creada exitosamente!');
    }

    public function edit(Category $category)
    {
        // Obtenemos las categorías padre, excluyéndose a sí misma para evitar bucles infinitos de jerarquía
        $parentCategories = Category::onlyParents()
                                    ->where('id', '!=', $category->id)
                                    ->get();

        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'required|boolean',
            'is_featured' => 'required|boolean',
            'parent_id' => 'nullable|exists:categories,id|not_in:' . $category->id, // Evita que sea su propio padre
        ]);

        $data = [
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'is_active' => $validated['is_active'],
            'is_featured' => $validated['is_featured'],
            'parent_id' => $validated['parent_id'],
        ];

        // Eliminar imagen si se marcó el checkbox
        if ($request->has('remove_image') && $category->image) {
            Storage::disk('public')->delete($category->image);
            $data['image'] = null;
        }

        // Subir nueva imagen
        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $path = $data['image'];
        $from = storage_path('app/public/' . $path);
        $to = public_path('storage/' . $path);

        if (!file_exists(dirname($to))) {
            mkdir(dirname($to), 0775, true);
        }

        copy($from, $to);

        $category->update($data);

        return redirect()->route('admin.categories.index')
                         ->with('success', '¡Categoría actualizada exitosamente!');
    }

    public function destroy(Category $category)
    {
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
                         ->with('success', '¡Categoría eliminada exitosamente!');
    }
}