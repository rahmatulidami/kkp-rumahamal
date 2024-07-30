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

    public function showByTitle($type, $title)
    {
        $post = Post::where('title', $title)
                    ->whereHas('categories', function ($query) use ($type) {
                        $query->where('name', $type);
                    })
                    ->firstOrFail(); // Mengambil post berdasarkan title dan type

        return view('posts.show-detail', compact('post'));
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
        $categories = Category::all();
        return view('posts.create', ['categories' => $categories]);
    }

    // Menyimpan post baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
        ]);

        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('content');

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public', $filename);
            $post->thumbnail = $filename;
        }

        $post->save();

        $post->categories()->sync($request->input('categories'));

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    // Menampilkan form untuk mengedit post
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        return view('posts.create', ['post' => $post, 'categories' => $categories]);
    }

    // Mengupdate post yang ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
        ]);

        $post = Post::findOrFail($id);
        $post->title = $request->input('title');
        $post->content = $request->input('content');

        if ($request->hasFile('thumbnail')) {
            // Hapus thumbnail lama jika ada
            if ($post->thumbnail) {
                Storage::delete('public/' . $post->thumbnail);
            }

            $file = $request->file('thumbnail');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public', $filename);
            $post->thumbnail = $filename;
        }

        $post->save();

        $post->categories()->sync($request->input('categories'));

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }
}
