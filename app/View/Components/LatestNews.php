<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Post;

class LatestNews extends Component
{
    public $posts;

    public function __construct($limit = 6)
    {
        // Obtener los últimos posts publicados
        $this->posts = Post::where('is_published', 1)
            ->latest()
            ->take($limit)
            ->get();
    }

    public function render()
    {
        return view('components.latest-news');
    }
}