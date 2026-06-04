<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Slider;
use App\Models\Brand;
use App\Models\Category;


class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::active()->get();
        $brands = Brand::all();
        $featuredProducts = Product::active()->featured()->take(6)->get();

        $categories = Category::where('is_active', true)->get();

        $categoriesFeature = Category::where('is_featured', true)->get();


        $weeklyDeals = Product::active()->inStock()->take(4)->get();
        $recentProducts = Product::active()->latest()->take(6)->get();


        return view('home', compact('sliders', 'brands', 'featuredProducts', 'weeklyDeals', 'recentProducts', 'categories', 'categoriesFeature'));
    }
}