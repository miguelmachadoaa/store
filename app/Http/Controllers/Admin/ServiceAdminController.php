<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceAdminController extends Controller
{
    public function index()
    {
        $services = Service::withCount(['sections', 'testimonials'])
            ->ordered()
            ->paginate(20);

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string',
            'hero_cta_text' => 'nullable|string|max:100',
            'hero_cta_link' => 'nullable|string|max:255',
            'hero_image' => 'nullable|image|max:2048',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'price' => 'nullable|numeric|min:0',
            'price_description' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'order' => 'nullable|integer',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        // Handle hero image upload
        if ($request->hasFile('hero_image')) {
            $validated['hero_image'] = $request->file('hero_image')->store('services/hero', 'public');
        }

        // Handle general image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        // Filter empty features
        if (isset($validated['features'])) {
            $validated['features'] = array_filter($validated['features'], fn ($f) => ! empty($f));
        }

        $service = Service::create($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Servicio creado exitosamente.');
    }

    public function show(Service $service)
    {
        $service->load(['sections', 'testimonials']);

        return view('admin.services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string',
            'hero_cta_text' => 'nullable|string|max:100',
            'hero_cta_link' => 'nullable|string|max:255',
            'hero_image' => 'nullable|image|max:2048',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'price' => 'nullable|numeric|min:0',
            'price_description' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'order' => 'nullable|integer',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        // Handle hero image upload
        if ($request->hasFile('hero_image')) {
            if ($service->hero_image) {
                Storage::disk('public')->delete($service->hero_image);
            }
            $validated['hero_image'] = $request->file('hero_image')->store('services/hero', 'public');
        }

        // Handle general image upload
        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        // Filter empty features
        if (isset($validated['features'])) {
            $validated['features'] = array_filter($validated['features'], fn ($f) => ! empty($f));
        }

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Servicio actualizado exitosamente.');
    }

    public function destroy(Service $service)
    {
        // Delete images
        if ($service->hero_image) {
            Storage::disk('public')->delete($service->hero_image);
        }
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Servicio eliminado exitosamente.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'services' => 'required|array',
            'services.*.id' => 'required|exists:services,id',
            'services.*.order' => 'required|integer',
        ]);

        foreach ($request->services as $serviceData) {
            Service::where('id', $serviceData['id'])->update(['order' => $serviceData['order']]);
        }

        return response()->json(['success' => true]);
    }
}
