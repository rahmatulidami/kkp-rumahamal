<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BeritaController extends Controller
{
    // Category ID for Pengumuman
    private $pengumumanCategoryId = 87;

    public function index()
    {
        // Fetch categories
        $categories = $this->fetchCategories();
        $categoryMap = array_column($categories, 'name', 'id');

        // Fetch posts
        $response = Http::get('http://rumahamal.usk.ac.id/wp-json/wp/v2/posts', [
            'per_page' => 100,
        ]);

        // Decode JSON response into an array
        $posts = $response->json();

        // Filter out posts with the 'Pengumuman' category
        $beritaPosts = array_filter($posts, function ($post) {
            return !in_array($this->pengumumanCategoryId, $post['categories'] ?? []);
        });

        // Extract image URL and map categories for berita posts
        foreach ($beritaPosts as &$post) {
            $post['image_url'] = $this->extractImageUrl($post['content']['rendered']);
            $post['content']['rendered'] = $this->sanitizeContent($post['content']['rendered']);
            $post['title']['rendered'] = $this->cleanTitle($post['title']['rendered']);
            $post['categories'] = array_map(function($categoryId) use ($categoryMap) {
                return $categoryMap[$categoryId] ?? 'Uncategorized';
            }, $post['categories'] ?? []);
        }

        // Paginate berita posts
        $currentPage = request()->get('page', 1);
        $perPage = 12;
        $offset = ($currentPage - 1) * $perPage;
        $totalPosts = count($beritaPosts);
        $beritaPosts = array_slice($beritaPosts, $offset, $perPage);

        $pagination = [
            'current_page' => $currentPage,
            'total_pages' => ceil($totalPosts / $perPage),
        ];

        // Send data to the view
        return view('berita.berita', compact('beritaPosts', 'pagination'));
    }

    public function pengumuman()
    {
        // Fetch categories
        $categories = $this->fetchCategories();
        $categoryMap = array_column($categories, 'name', 'id');

        // Fetch posts
        $response = Http::get('http://rumahamal.usk.ac.id/wp-json/wp/v2/posts', [
            'per_page' => 100,
        ]);

        // Log response status and body for debugging
        Log::info('API Response Status: ' . $response->status());
        Log::info('API Response Body: ' . $response->body());

        // Initialize posts array
        $posts = [];

        // Check if the response is successful and contains data
        if ($response->successful()) {
            // Decode JSON response into an array
            $posts = $response->json();

            // Fetch Pengumuman posts
            $pengumumanPosts = array_filter($posts, function ($post) {
                return in_array($this->pengumumanCategoryId, $post['categories'] ?? []);
            });

            // Extract image URL and map categories for pengumuman posts
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
        } else {
            // Log error response
            Log::error('API Response Error: ' . $response->body());

            // Handle error
            $pengumumanPosts = [];
            $pagination = [];
        }

        // Send data to the view
        return view('pengumuman.pengumuman', compact('pengumumanPosts', 'pagination'));
    }

    private function fetchCategories()
    {
        $response = Http::get('http://rumahamal.usk.ac.id/wp-json/wp/v2/categories');
        
        $categories = $response->json();
        
        // Map categories to get the necessary fields and decode HTML entities in names
        return array_map(function ($category) {
            return [
                'id' => $category['id'],
                'name' => htmlspecialchars_decode($category['name']),
                'slug' => $category['slug'],
            ];
        }, $categories);
    }

    private function extractImageUrl($content)
    {
        preg_match('/<img[^>]+src="([^">]+)"/', $content, $matches);
        return $matches[1] ?? url('assets/img/default.jpeg');
    }

    private function sanitizeContent($content)
    {
        // Decode HTML entities
        $content = htmlspecialchars_decode($content);
        
        // Strip unwanted HTML tags
        $content = strip_tags($content, '<p><a><b><i><u><strong><em><br>');
        
        // Replace &amp; with &
        $content = str_replace('&amp;', '&', $content);
        
        return $content;
    }

    private function cleanTitle($title)
    {
        // Remove patterns like #3huruf; and similar
        $title = preg_replace('/#\d+huruf;/', '', $title);
        $title = html_entity_decode($title);
        return trim($title);
    }


    public function show($id)
    {
        // Fetch the post details
        $response = Http::get('http://rumahamal.usk.ac.id/wp-json/wp/v2/posts/' . $id);
    
        if ($response->successful()) {
            $berita = $response->json();
    
            // Extract images from the post content
            preg_match_all('/<img[^>]+src="([^">]+)"/', $berita['content']['rendered'], $matches);
            $images = array_unique($matches[1]);
    
            // Set the main image
            $mainImage = $images[0] ?? asset('assets/img/default.jpeg');
    
            // Remove the main image from the content
            $filteredContent = str_replace('<img src="' . $mainImage . '"', '', $berita['content']['rendered']);
    
            // Fetch recent posts
            $recent_posts_response = Http::get('http://rumahamal.usk.ac.id/wp-json/wp/v2/posts', [
                'per_page' => 5,
            ]);
            $recent_posts = $recent_posts_response->json();
    
            // Add image_url to each recent post
            foreach ($recent_posts as &$post) {
                $post['image_url'] = $this->extractImageUrl($post['content']['rendered']) ?? asset('assets/img/default.jpeg');
            }
    
            // Fetch all tags
            $tags_response = Http::get('http://rumahamal.usk.ac.id/wp-json/wp/v2/tags');
            $tags = $tags_response->json();
    
            // Fetch comments
            $comments_response = Http::get('http://rumahamal.usk.ac.id/wp-json/wp/v2/comments', [
                'post' => $id,
            ]);
            $comments = $comments_response->json();
    
            $comment_count = $berita['comment_count'] ?? 0;
    
            return view('berita.detail-berita', compact('berita', 'recent_posts', 'tags', 'mainImage', 'filteredContent', 'comment_count', 'comments'));
        } else {
            abort(404, 'Berita tidak ditemukan');
        }
    }    
    
}
