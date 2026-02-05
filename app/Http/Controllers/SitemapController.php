<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $products = Product::where('is_active', true)->latest()->get();
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();

        $content = view('sitemap', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
        ]);

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
}
