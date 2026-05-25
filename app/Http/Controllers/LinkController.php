<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Setting;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    // ==========================================
    // VISTA PÚBLICA (ESTILO LINKTREE)
    // ==========================================
    public function publicIndex()
    {
        $links = Link::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        $settings = Setting::first(); // Para usar el logo o nombre de la tienda si hace falta

        return view('links.public', compact('links', 'settings'));
    }

    // ==========================================
    // PANEL ADMINISTRATIVO (CRUD)
    // ==========================================
    public function index()
    {
        $links = Link::orderBy('sort_order', 'asc')->get();
        return view('admin.links.index', compact('links'));
    }

    public function create()
    {
        return view('admin.links.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'required|integer',
        ]);

        Link::create($request->all() + ['is_active' => $request->has('is_active')]);

        return redirect()->route('admin.links.index')->with('success', 'Enlace creado correctamente.');
    }

    public function edit(Link $link)
    {
        return view('admin.links.edit', compact('link'));
    }

    public function update(Request $request, Link $link)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'required|integer',
        ]);

        $link->update($request->all() + ['is_active' => $request->has('is_active')]);

        return redirect()->route('admin.links.index')->with('success', 'Enlace actualizado con éxito.');
    }

    public function destroy(Link $link)
    {
        $link->delete();
        return redirect()->route('admin.links.index')->with('success', 'Enlace eliminado.');
    }
}