<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StoneAdminController extends Controller
{
    public function index()
    {
        $stones = Stone::orderBy('sort_order', 'asc')->latest()->paginate(10);
        return view('admin.stones.index', compact('stones'));
    }

    public function create()
    {
        return view('admin.stones.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255|unique:stones,name',
            'subtitle'          => 'nullable|string|max:255',
            'short_description' => 'required|string',
            'description'       => 'required|string',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'zodiac_signs'      => 'nullable|string|max:255',
            'sort_order'        => 'required|integer|min:0',
            'is_active'         => 'required|boolean',
        ]);

        $data = [
            'name'              => $validated['name'],
            'slug'              => Str::slug($validated['name']),
            'subtitle'          => $validated['subtitle'] ?? null,
            'short_description' => $validated['short_description'],
            'description'       => $validated['description'],
            'zodiac_signs'      => $validated['zodiac_signs'] ?? null,
            'sort_order'        => $validated['sort_order'],
            'is_active'         => $validated['is_active'],
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('stones', 'r2');
        }

        Stone::create($data);

        return redirect()->route('admin.stones.index')
                        ->with('success', 'Piedra creada exitosamente en Cloudflare R2!');
    }

    public function edit(Stone $stone)
    {
        return view('admin.stones.form', compact('stone'));
    }

    public function update(Request $request, Stone $stone)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255|unique:stones,name,' . $stone->id,
            'subtitle'          => 'nullable|string|max:255',
            'short_description' => 'required|string',
            'description'       => 'required|string',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'zodiac_signs'      => 'nullable|string|max:255',
            'sort_order'        => 'required|integer|min:0',
            'is_active'         => 'required|boolean',
        ]);

        $data = [
            'name'              => $validated['name'],
            'slug'              => Str::slug($validated['name']),
            'subtitle'          => $validated['subtitle'] ?? null,
            'short_description' => $validated['short_description'],
            'description'       => $validated['description'],
            'zodiac_signs'      => $validated['zodiac_signs'] ?? null,
            'sort_order'        => $validated['sort_order'],
            'is_active'         => $validated['is_active'],
        ];

        // Eliminar imagen de R2 si se marcó el checkbox
        if ($request->has('remove_image') && $stone->image) {
            Storage::disk('r2')->delete($stone->image);
            $data['image'] = null;
        }

        // Subir nueva imagen a Cloudflare R2
        if ($request->hasFile('image')) {
            if ($stone->image) {
                Storage::disk('r2')->delete($stone->image);
            }
            $data['image'] = $request->file('image')->store('stones', 'r2');
        }

        $stone->update($data);

        return redirect()->route('admin.stones.index')
                        ->with('success', 'Piedra actualizada exitosamente!');
    }

    public function destroy(Stone $stone)
    {
        if ($stone->image) {
            Storage::disk('r2')->delete($stone->image);
        }

        $stone->delete();

        return redirect()->route('admin.stones.index')
                        ->with('success', 'Piedra eliminada exitosamente por completo!');
    }
}