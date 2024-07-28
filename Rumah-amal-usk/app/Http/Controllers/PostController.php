<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('categories')->get();
        return view('posts.index', compact('posts'));
    }

    public function landing_page()
    {
        $posts = Post::with('categories')->latest()->take(6)->get(); // Ambil 6 post terbaru
        return view('landing.home', compact('posts'));
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

        // Sinkronisasi tags
        $tags = explode(',', $request->input('tags'));
        $tagIds = [];

        if ($tags) {
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
                $tagIds[] = $tag->id;
            }
        }

        $post->tags()->sync($tagIds);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    // Metode lain seperti edit, update, destroy...
}
