<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BeritaController extends Controller
{
    // Category ID for Pengumuman
    private $pengumumanCategoryId = 87;

    // Cache time in minutes
    private $cacheTime = 60;

    public function index(Request $request)
    {
        $searchQuery = $request->get('search');
        $tagFilter = $request->get('tag');
    
        // Fetch categories with caching
        $categories = Cache::remember('categories', $this->cacheTime, function() {
            return $this->fetchCategories();
        });
    
        $categoryMap = array_column($categories, 'name', 'id');
    
        // Fetch posts (cache for 60 minutes)
        $posts = Cache::remember('posts', $this->cacheTime, function() {
            $response = Http::get('http://rumahamal.usk.ac.id/api/wp-json/wp/v2/posts', [
                'per_page' => 100,
            ]);
            return $response->json();
        });
    
        // Filter out posts with category ID 88 and 'Pengumuman'
        $beritaPosts = array_filter($posts, function ($post) {
            return !in_array($this->pengumumanCategoryId, $post['categories'] ?? [])
                && !in_array(88, $post['categories'] ?? []);
        });
    
        // Filter berdasarkan pencarian judul
        if (!empty($searchQuery)) {
            $beritaPosts = array_filter($beritaPosts, function ($post) use ($searchQuery) {
                return stripos($post['title']['rendered'], $searchQuery) !== false;
            });
        }
    
        // Filter berdasarkan tag yang dipilih
        if (!empty($tagFilter)) {
            $beritaPosts = array_filter($beritaPosts, function ($post) use ($tagFilter) {
                return in_array($tagFilter, $post['tags'] ?? []);
            });
        }
    
        // Process posts for displaying
        foreach ($beritaPosts as &$post) {
            $post['image_url'] = $this->extractImageUrl($post['content']['rendered']);
            $post['content']['rendered'] = $this->sanitizeContent($post['content']['rendered']);
            $post['title']['rendered'] = $this->cleanTitle($post['title']['rendered']);
            $post['categories'] = array_map(function($categoryId) use ($categoryMap) {
                return $categoryMap[$categoryId] ?? 'Uncategorized';
            }, $post['categories'] ?? []);
        }
    
        // Pagination
        $currentPage = request()->get('page', 1);
        $perPage = 12;
        $offset = ($currentPage - 1) * $perPage;
        $totalPosts = count($beritaPosts);
        $beritaPosts = array_slice($beritaPosts, $offset, $perPage);
    
        $pagination = [
            'current_page' => $currentPage,
            'total_pages' => ceil($totalPosts / $perPage),
        ];
    
        return view('berita.berita', compact('beritaPosts', 'pagination', 'searchQuery', 'tagFilter'));
    }
    

    public function pengumuman(Request $request)
    {
        $searchQuery = $request->get('search');
        $tagFilter = $request->get('tag'); // Pastikan tag filter diambil dari request
    
        // Fetch categories from cache
        $categories = Cache::remember('categories', $this->cacheTime, function() {
            return $this->fetchCategories();
        });
    
        $categoryMap = array_column($categories, 'name', 'id');
    
        // Fetch posts from cache
        $posts = Cache::remember('posts', $this->cacheTime, function() {
            $response = Http::get('http://rumahamal.usk.ac.id/api/wp-json/wp/v2/posts', [
                'per_page' => 100,
            ]);
            return $response->json();
        });
    
        // Filter posts untuk kategori Pengumuman
        $pengumumanPosts = array_filter($posts, function ($post) {
            return in_array($this->pengumumanCategoryId, $post['categories'] ?? []);
        });
    
        // Jika ada pencarian, filter berdasarkan judul
        if (!empty($searchQuery)) {
            $pengumumanPosts = array_filter($pengumumanPosts, function ($post) use ($searchQuery) {
                return stripos($post['title']['rendered'], $searchQuery) !== false;
            });
        }
    
        // Filter berdasarkan tag yang dipilih
        if (!empty($tagFilter)) {
            $pengumumanPosts = array_filter($pengumumanPosts, function ($post) use ($tagFilter) {
                return in_array($tagFilter, $post['tags'] ?? []);
            });
        }
    
        // Process posts for displaying
        foreach ($pengumumanPosts as &$post) {
            $post['image_url'] = $this->extractImageUrl($post['content']['rendered']);
            $post['content']['rendered'] = $this->sanitizeContent($post['content']['rendered']);
            $post['title']['rendered'] = $this->cleanTitle($post['title']['rendered']);
            $post['categories'] = array_map(function($categoryId) use ($categoryMap) {
                return $categoryMap[$categoryId] ?? 'Uncategorized';
            }, $post['categories'] ?? []);
        }
    
        // Paginate pengumuman posts
        $currentPage = request()->get('page', 1);
        $perPage = 12;
        $offset = ($currentPage - 1) * $perPage;
        $totalPosts = count($pengumumanPosts);
        $pengumumanPosts = array_slice($pengumumanPosts, $offset, $perPage);
    
        $pagination = [
            'current_page' => $currentPage,
            'total_pages' => ceil($totalPosts / $perPage),
        ];
    
        // Send data to the view
        return view('pengumuman.pengumuman', compact('pengumumanPosts', 'pagination', 'searchQuery', 'tagFilter'));
    }
    
    private function fetchCategories()
    {
        $response = Http::get('http://rumahamal.usk.ac.id/api/wp-json/wp/v2/categories');
        
        return array_map(function ($category) {
            return [
                'id' => $category['id'],
                'name' => htmlspecialchars_decode($category['name']),
                'slug' => $category['slug'],
            ];
        }, $response->json());
    }

    private function extractImageUrl($content)
    {
        preg_match('/<img[^>]+src="([^">]+)"/', $content, $matches);
        return $matches[1] ?? url('assets/img/default.jpeg');
    }

    private function sanitizeContent($content)
    {
        $content = htmlspecialchars_decode($content);
        $content = strip_tags($content, '<p><a><b><i><u><strong><em><br>');
        return str_replace(['&', "'"], ['&amp;', '&#8217;'], $content);
    }

    private function cleanTitle($title)
    {
        return str_replace("&#8217;", "'", html_entity_decode(trim($title), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    }

    public function show($slug)
    {
        // Fetch the post by slug from the API and cache it
        $berita = Cache::remember('post_' . $slug, $this->cacheTime, function() use ($slug) {
            $response = Http::get('http://rumahamal.usk.ac.id/api/wp-json/wp/v2/posts', [
                'slug' => $slug,
            ]);
    
            $posts = $response->json();
    
            return !empty($posts) ? $posts[0] : null;
        });
    
        if (!$berita) {
            abort(404, 'Berita tidak ditemukan');
        }
    
        // Bersihkan judul dan ekstrak gambar utama
        $berita['title']['rendered'] = $this->cleanTitle($berita['title']['rendered']);
        $mainImage = $this->extractImageUrl($berita['content']['rendered']);
    
        // Ambil recent posts
        $recent_posts = Cache::remember('recent_posts', $this->cacheTime, function() {
            $response = Http::get('http://rumahamal.usk.ac.id/api/wp-json/wp/v2/posts', ['per_page' => 5]);
            return array_filter($response->json(), function ($post) {
                return !in_array(88, $post['categories'] ?? []);
            });
        });
    
        foreach ($recent_posts as &$post) {
            $post['image_url'] = $this->extractImageUrl($post['content']['rendered']);
            $post['title']['rendered'] = $this->cleanTitle($post['title']['rendered']);
        }
    
        // Ambil tag yang hanya terkait dengan berita ini
        $beritaTags = $berita['tags'] ?? [];
    
        if (!empty($beritaTags)) {
            $tagIds = implode(',', $beritaTags); // Gabungkan ID menjadi string "68,85,67"
            $filteredTags = Cache::remember('tags_' . $tagIds, $this->cacheTime, function() use ($tagIds) {
                $response = Http::get("http://rumahamal.usk.ac.id/api/wp-json/wp/v2/tags", [
                    'include' => $tagIds, // Ambil hanya tag yang dibutuhkan
                ]);
                return $response->json();
            });
        } else {
            $filteredTags = [];
        }
    
        // Ambil comments
        $comments = Cache::remember('comments_' . $berita['id'], $this->cacheTime, function() use ($berita) {
            $response = Http::get('http://rumahamal.usk.ac.id/api/wp-json/wp/v2/comments', ['post' => $berita['id']]);
            return $response->json();
        });
    
        $comment_count = $berita['comment_count'] ?? 0;
    
        return view('berita.detail-berita', compact('berita', 'recent_posts', 'filteredTags', 'mainImage', 'comment_count', 'comments'));
    }
    
}
