<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BeritaController extends Controller
{
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

        // Extract image URL and map categories
        foreach ($posts as &$post) {
            $post['image_url'] = $this->extractImageUrl($post['content']['rendered']);
            $post['categories'] = array_map(function($categoryId) use ($categoryMap) {
                return $categoryMap[$categoryId] ?? 'Uncategorized';
            }, $post['categories'] ?? []);
        }

        // Paginate data
        $currentPage = request()->get('page', 1);
        $perPage = 12;
        $offset = ($currentPage - 1) * $perPage;
        $totalPosts = count($posts);
        $posts = array_slice($posts, $offset, $perPage);

        $pagination = [
            'current_page' => $currentPage,
            'total_pages' => ceil($totalPosts / $perPage),
        ];

        // Send data to the view
        return view('berita.berita', compact('posts', 'pagination'));
    }

    private function fetchCategories()
    {
        $response = Http::get('http://rumahamal.usk.ac.id/wp-json/wp/v2/categories');
        
        $categories = $response->json();
        
        // Map categories to get the necessary fields
        return array_map(function ($category) {
            return [
                'id' => $category['id'],
                'name' => $category['name'],
                'slug' => $category['slug'],
            ];
        }, $categories);
    }

    private function extractImageUrl($content)
    {
        // Extract the first image URL from the rendered content using regex
        preg_match('/<img[^>]+src="([^">]+)"/', $content, $matches);
        return $matches[1] ?? null;
    }
}
