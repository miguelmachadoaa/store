<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Slider;
use App\Models\Brand;


class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::active()->get();
        $brands = Brand::all();
        $featuredProducts = Product::active()->featured()->take(6)->get();

         $weeklyDeals = Product::active()->inStock()->take(4)->get();
        $recentProducts = Product::active()->latest()->take(6)->get();


        return view('home', compact('sliders', 'brands', 'featuredProducts', 'weeklyDeals', 'recentProducts'));
    }
}