<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewAdminController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'product'])->latest()->paginate(20);

        return view('admin.resenas.index', compact('reviews'));
    }

    public function show(Review $review)
    {
        $review->load(['user', 'product.category']);

        return view('admin.resenas.show', compact('review'));
    }

    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);

        return redirect()->back()->with('success', 'Reseña aprobada correctamente.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->back()->with('success', 'Reseña eliminada correctamente.');
    }
}
