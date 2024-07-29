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

    public function landingPage()
    {
        $pengumumanPosts = Post::whereHas('categories', function ($query) {
            $query->where('name', '1');
        })->latest()->limit(6)->get();

        $beritaPosts = Post::whereHas('categories', function ($query) {
            $query->where('name', 'Pendidikan');
        })->latest()->limit(6)->get();

        return view('landing.home', compact('pengumumanPosts', 'beritaPosts'));
    }

    public function showBerita()
    {
        // Ambil posts dengan kategori 'Berita', urutkan berdasarkan tanggal terbaru, dan paginate dengan 6 posts per halaman
        $posts = Post::whereHas('categories', function ($query) {
            $query->where('name', 'Pendidikan'); // Pastikan 'Berita' adalah nama kategori yang benar
        })->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal terbaru
          ->paginate(6);

        return view('posts.show', ['posts' => $posts, 'type' => 'Berita']);
    }

    public function showPengumuman()
    {
        // Ambil posts dengan kategori 'Pengumuman', urutkan berdasarkan tanggal terbaru, dan paginate dengan 6 posts per halaman
        $posts = Post::whereHas('categories', function ($query) {
            $query->where('name', 'Pengumuman'); // Pastikan 'Pengumuman' adalah nama kategori yang benar
        })->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal terbaru
          ->paginate(6);

        return view('posts.show', ['posts' => $posts, 'type' => 'Pengumuman']);
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
