<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Tag;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::where('is_published', 1)->latest()->paginate(9);
        return view('blog.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('blog.show', compact('post'));
    }

    public function tag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $posts = $tag->posts()->where('is_published', 1)->paginate(9);

        return view('blog.tag', compact('tag', 'posts'));
    }
}
