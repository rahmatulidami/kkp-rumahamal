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

        // Fetch categories and posts from the API
        $categories = $this->fetchCategories();
        $allPosts = $this->fetchAllPosts();

        // Check if categories and posts are arrays
        if (!is_array($categories) || !is_array($allPosts)) {
            abort(500, 'Invalid data received from API.');
        }

        // Map category IDs to names and decode HTML entities
        $categoryMap = array_column($categories, 'name', 'id');
        $categoryMap = array_map('html_entity_decode', $categoryMap);

        // Filter and sort posts
        $pengumumanPosts = array_filter($allPosts, function($post) {
            return is_array($post) && in_array(87, $post['categories'] ?? []);
        });

        $beritaPosts = array_filter($allPosts, function($post) {
            return is_array($post) && !in_array(87, $post['categories'] ?? []);
        });

        usort($pengumumanPosts, fn($a, $b) => strtotime($b['date'] ?? '1970-01-01') - strtotime($a['date'] ?? '1970-01-01'));
        usort($beritaPosts, fn($a, $b) => strtotime($b['date'] ?? '1970-01-01') - strtotime($a['date'] ?? '1970-01-01'));

        $latestPengumumanPosts = array_slice($pengumumanPosts, 0, 3);
        $latestBeritaPosts = array_slice($beritaPosts, 0, 3);

        // Replace category IDs with names and decode HTML entities
        foreach ($latestPengumumanPosts as &$post) {
            $post['categories'] = array_map(fn($id) => $categoryMap[$id] ?? 'Uncategorized', $post['categories'] ?? []);
            $post['title']['rendered'] = str_replace('&amp;', '&', $post['title']['rendered'] ?? 'Untitled');
        }

        foreach ($latestBeritaPosts as &$post) {
            $post['categories'] = array_map(fn($id) => $categoryMap[$id] ?? 'Uncategorized', $post['categories'] ?? []);
            $post['title']['rendered'] = str_replace('&amp;', '&', $post['title']['rendered'] ?? 'Untitled');
        }

        // Return the home view with the latest posts and categories
        return view('landing.home', [
            'latestPengumumanPosts' => $latestPengumumanPosts,
            'latestBeritaPosts' => $latestBeritaPosts
        ]);
    }

    private function fetchCategories()
    {
        $response = Http::get('http://rumahamal.usk.ac.id/wp-json/wp/v2/categories');
        
        // Check if response is an array
        $categories = $response->json();
        if (!is_array($categories)) {
            abort(500, 'Failed to fetch categories.');
        }
        
        // Map categories to get the necessary fields
        return array_map(function ($category) {
            return [
                'id' => $category['id'] ?? 0,
                'name' => $category['name'] ?? 'Unknown',
                'slug' => $category['slug'] ?? '',
            ];
        }, $categories);
    }

    private function fetchAllPosts()
    {
        $response = Http::get('http://rumahamal.usk.ac.id/wp-json/wp/v2/posts', ['per_page' => 100]);

        // Check if response is an array
        $posts = $response->json();
        if (!is_array($posts)) {
            abort(500, 'Failed to fetch posts.');
        }

        // Process the posts to include necessary fields
        return array_map(function ($post) {
            return [
                'id' => $post['id'] ?? 0,
                'image_url' => $this->extractImageUrl($post),
                'categories' => $post['categories'] ?? [],
                'title' => $post['title'] ?? [],
                'link' => $post['link'] ?? '',
                'date' => $post['date'] ?? ''
            ];
        }, $posts);
    }

    private function extractImageUrl($post)
    {
        if (isset($post['content']['rendered']) && is_string($post['content']['rendered'])) {
            $content = $post['content']['rendered'];
            preg_match('/<img[^>]+src="([^">]+)"/', $content, $matches);
            return $matches[1] ?? url('assets/img/default.jpeg');
        }

        return url('assets/img/default.jpeg');
    }
}
