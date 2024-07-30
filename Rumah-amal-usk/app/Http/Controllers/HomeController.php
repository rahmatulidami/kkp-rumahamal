<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::id()) {
            $usertype = Auth::user()->usertype;

            if ($usertype == 'user') {
                return view('user.dashboard');
            } elseif ($usertype == 'admin') {
                return view('admin.dashboard');
            } else {
                return view('auth.login');
            }
        }

        // Fetch categories and latest 3 posts from the API
        $categories = $this->fetchCategories();
        $latestPosts = $this->fetchLatestPosts();

        // Map category IDs to names
        $categoryMap = array_column($categories, 'name', 'id');

        // Replace category IDs in posts with category names
        foreach ($latestPosts as &$post) {
            $post['categories'] = array_map(function($categoryId) use ($categoryMap) {
                return $categoryMap[$categoryId] ?? 'Uncategorized';
            }, $post['categories']);
        }

        // Return the home view with the latest posts and categories
        return view('landing.home', ['latestPosts' => $latestPosts]);
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

    private function fetchLatestPosts()
    {
        $response = Http::get('http://rumahamal.usk.ac.id/wp-json/wp/v2/posts', ['per_page' => 3]);

        $latestPosts = $response->json();

        // Process the posts to include necessary fields
        return array_map(function ($post) {
            return [
                'image_url' => $this->extractImageUrl($post),
                'categories' => $post['categories'] ?? [],
                'title' => $post['title']['rendered'] ?? '',
                'link' => $post['link'] ?? '',
                'date' => $post['date'] ?? ''
            ];
        }, $latestPosts);
    }

    private function extractImageUrl($post)
    {
        if (isset($post['content']['rendered'])) {
            $content = $post['content']['rendered'];
            preg_match('/<img[^>]+src="([^">]+)"/', $content, $matches);
            return $matches[1] ?? null;
        }

        return null;
    }
}
