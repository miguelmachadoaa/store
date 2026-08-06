<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:3|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Validación de imagen (máx 2MB)
        ]);

        $existingReview = Review::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Ya has enviado una reseña para este producto.');
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reviews', 'r2');
        }

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'image' => $imagePath,
            'is_approved' => false,
        ]);

        return redirect()->back()->with('success', 'Gracias por tu reseña. Será publicada después de ser moderada.');
    }
}