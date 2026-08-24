<?php

namespace App\Http\Controllers;

use App\Models\Stone;
use Illuminate\Http\Request;

class StoneController extends Controller
{
    /**
     * Muestra el catálogo/listado de piedras activas en el frontend.
     */
    public function index()
    {
        $stones = Stone::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        return view('stones.index', compact('stones'));
    }

    /**
     * Muestra la página de detalle de una piedra por su slug.
     */
    public function show(string $slug)
    {
        $stone = Stone::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Opcional: Obtener piedras relacionadas para recomendar al final de la página
        $relatedStones = Stone::where('is_active', true)
            ->where('id', '!=', $stone->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('stones.show', compact('stone', 'relatedStones'));
    }
}