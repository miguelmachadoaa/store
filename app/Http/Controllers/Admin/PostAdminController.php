<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;

class PostAdminController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $tags = Tag::all();
        return view('admin.posts.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $post = Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'is_published' => $request->is_published ?? 0,
            'user_id' => auth()->id(),
            'image' => $request->file('image')?->store('posts', 'public')
        ]);

        $post->tags()->sync($request->tags);

        return redirect()->route('admin.posts.index')->with('success', 'Artículo creado.');
    }

    public function edit(Post $post)
    {
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $post->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'is_published' => $request->is_published,
            'image' => $request->file('image')?->store('posts', 'public') ?? $post->image
        ]);

        $post->tags()->sync($request->tags);

        return redirect()->route('admin.posts.index')->with('success', 'Artículo actualizado.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return back()->with('success', 'Artículo eliminado.');
    }
}
