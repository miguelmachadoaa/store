<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function toggle(Product $product)
    {
        $user = auth()->user();

        // Si no ha iniciado sesión, el JS se encargará del localStorage.
        // Solo respondemos éxito y notificamos que es un "guest" (invitado).
        if (!$user) {
            return response()->json([
                'success' => true,
                'status' => 'local', 
                'message' => 'Acción procesada localmente',
                'count' => 0
            ]);
        }

        // Flujo normal para usuarios autenticados
        $exists = Wishlist::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($exists) {
            $exists->delete();
            $status = 'removed';
            $message = 'Producto eliminado de favoritos';
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            $status = 'added';
            $message = 'Producto agregado a favoritos';
        }

        return response()->json([
            'success' => true,
            'status' => $status,
            'message' => $message,
            'count' => $user->favorites()->count()
        ]);
    }
}