<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderCommentController extends Controller
{
    public function store(Request $request, Order $order)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Agregadas extensiones comunes por seguridad
        ]);

        $filePath = null;

        // Si el usuario subió una foto (ej: foto de la guía de despacho)
        if ($request->hasFile('photo')) {
            // Se guardará directamente en tu bucket de Cloudflare R2
            $filePath = $request->file('photo')->store('order-comments', 'r2');
        }

        $order->comments()->create([
            'comment' => $request->comment,
            'file_path' => $filePath,
        ]);

        return back()->with('flash.banner', 'Contenido post-venta agregado con éxito.');
    }
}