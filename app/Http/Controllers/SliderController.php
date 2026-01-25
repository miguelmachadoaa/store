<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Slider::query();

        // Búsqueda
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('subtitle', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtro por estado
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        $sliders = $query->ordered()->paginate(10)->withQueryString();

        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|url|max:500',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'text_position' => 'required|in:left,center,right',
            'text_color' => 'required|in:light,dark',
        ]);

        // Manejar la imagen
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('sliders', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        Slider::create($validated);

        return redirect()->route('sliders.index')
            ->with('success', 'Slider creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        return view('admin.sliders.show', compact('slider'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|url|max:500',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'text_position' => 'required|in:left,center,right',
            'text_color' => 'required|in:light,dark',
        ]);

        // Manejar la imagen
        if ($request->hasFile('image')) {
            // Eliminar imagen anterior
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }
            $validated['image'] = $request->file('image')->store('sliders', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $slider->update($validated);

        return redirect()->route('sliders.index')
            ->with('success', 'Slider actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        // Eliminar imagen si existe
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return redirect()->route('sliders.index')
            ->with('success', 'Slider eliminado exitosamente.');
    }

    /**
     * Reordenar sliders
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'sliders' => 'required|array',
            'sliders.*.id' => 'required|exists:sliders,id',
            'sliders.*.order' => 'required|integer|min:0',
        ]);

        foreach ($request->sliders as $sliderData) {
            Slider::where('id', $sliderData['id'])
                  ->update(['order' => $sliderData['order']]);
        }

        return response()->json(['success' => true]);
    }
}