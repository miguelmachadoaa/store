<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FrontLayout extends Component
{
    /**
     * Create a new component instance.
     */

    public $sliders;
    public $brands;

    public function __construct($sliders = null, $brands = null)
    {
        $this->sliders = $sliders;
        $this->brands = $brands;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.front-layout', [
            'sliders' => $this->sliders,
            'brands' => $this->brands,
        ]);
    }
}
