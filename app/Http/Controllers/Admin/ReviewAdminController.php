<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewAdminController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'product', 'images'])->latest()->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        return view('admin.reviews.create', compact('users', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'is_approved' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $review = Review::create([
            'user_id' => $validated['user_id'],
            'product_id' => $validated['product_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_approved' => $request->has('is_approved') ? 1 : 0,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                // Almacena en R2 dentro de la carpeta 'reviews'
                $path = $file->store('reviews', 'r2');
                $review->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('admin.reviews.index')->with('success', 'Reseña creada correctamente.');
    }

    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);
        return back()->with('success', 'Reseña aprobada.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Reseña eliminada.');
    }

    public function getUserProducts(User $user)
    {
        // Obtiene productos de las órdenes del usuario (sin duplicados)
        // Ajusta las relaciones según la estructura de tu BD (ej. $user->orders()->with('products'))
        $products = Product::join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.user_id', $user->id)
            ->select('products.*')
            ->distinct()
            ->get();

        return response()->json($products);
    }
}