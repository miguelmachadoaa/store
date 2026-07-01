<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('id', 'desc')->paginate(10);
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'is_active');

        // Guardar el logo en Cloudflare R2
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('brands', 'r2');
        }

        Brand::create($data);

        return redirect()->route('brands.index')->with('success', 'Marca creada exitosamente en Cloudflare R2.');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required',
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'is_active');

        // Actualizar el logo en Cloudflare R2
        if ($request->hasFile('logo')) {
            // Eliminar logo anterior de R2 si existe
            if ($brand->logo) {
                Storage::disk('r2')->delete($brand->logo);
            }
            $data['logo'] = $request->file('logo')->store('brands', 'r2');
        }

        $brand->update($data);

        return redirect()->route('brands.index')->with('success', 'Marca actualizada exitosamente.');
    }

    public function destroy(Brand $brand)
    {
        // Eliminar logo de Cloudflare R2 antes de borrar la marca
        if ($brand->logo) {
            Storage::disk('r2')->delete($brand->logo);
        }

        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Marca eliminada por completo.');
    }
}