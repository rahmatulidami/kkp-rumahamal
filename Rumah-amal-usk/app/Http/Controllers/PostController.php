<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category; // Pastikan Anda mengimpor model Category
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('categories')->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        // Ambil semua kategori untuk menampilkan pilihan kategori di form
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi dan simpan post baru
        $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required',
            'categories' => 'required|array',
        ]);

        // Simpan file thumbnail
        $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');

        // Simpan data post
        $post = Post::create([
            'title' => $request->input('title'),
            'thumbnail' => $thumbnailPath,
            'content' => $request->input('content'),
        ]);

        // Sinkronisasi kategori
        $post->categories()->sync($request->input('categories'));

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    // Metode lain seperti edit, update, destroy...
}
