<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Product;

class ProductCard extends Component
{
    public $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function render()
    {
        return view('components.product-card');
    }
}