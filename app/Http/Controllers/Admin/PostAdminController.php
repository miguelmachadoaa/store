<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Str;

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
        // La validación del backend se encarga de exigir el contenido de TinyMCE de forma segura
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'tags' => 'nullable|array',
            'image' => 'nullable|image|max:2048' // Opcional: añade seguridad a tus imágenes
        ]);


        $post = Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'is_published' => $request->is_published ?? 0,
            'user_id' => auth()->id(),
            'image' => $request->file('image')?->store('blog', 'r2')
        ]);

        // Si $request->tags viene vacío, pasamos un array vacío para limpiar relaciones previas sin romper la app
        $post->tags()->sync($request->tags ?? []);

        return redirect()->route('admin.posts.index')->with('success', 'Artículo creado exitosamente.');
    }

    public function edit(Post $post)
    {
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'tags'));
    }

  public function update(Request $request, Post $post)
{
    // 1. Añadimos la regla para 'image' en la validación
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required',
        'tags' => 'nullable|array',
        'image' => 'nullable|image|max:2048' // Asegura que sea una imagen real y no un archivo fantasma
    ]);

    // 2. Manejo controlado de la imagen
    $imagePath = $post->image; // Por defecto dejamos la que ya tiene

    // Comprobamos explícitamente si el archivo se subió de forma válida
    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        $imagePath = $request->file('image')->store('blog', 'r2');
    }

    // 3. Actualizamos el post con el path seguro
    $post->update([
        'title' => $request->title,
        'slug' => Str::slug($request->title),
        'excerpt' => $request->excerpt,
        'content' => $request->content,
        'is_published' => $request->is_published ?? 0,
        'image' => $imagePath
    ]);

    // 4. Sincronizar etiquetas
    $post->tags()->sync($request->tags ?? []);

    return redirect()->route('admin.posts.index')->with('success', 'Artículo actualizado.');
}

    public function destroy(Post $post)
    {
        $post->delete();
        return back()->with('success', 'Artículo eliminado.');
    }
}
