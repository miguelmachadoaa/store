<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::where('is_published', 1)->latest()->paginate(9);
        $title = 'Nuestro Blog - '.config('app.name');

        return view('blog.index', compact('posts', 'title'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $title = $post->title.' - Blog - '.config('app.name');

        return view('blog.show', compact('post', 'title'));
    }

    public function tag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $posts = $tag->posts()->where('is_published', 1)->paginate(9);
        $title = "Artículos sobre {$tag->name} - Blog - ".config('app.name');

        return view('blog.tag', compact('tag', 'posts', 'title'));
    }
}
