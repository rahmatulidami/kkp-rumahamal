<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use DOMDocument;

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

        // Log the fetched data
        Log::info('All Posts Count:', [count($allPosts)]);
        Log::info('Categories:', $categories);

        if (!is_array($categories) || !is_array($allPosts)) {
            abort(500, 'Invalid data received from API.');
        }

        // Map category IDs to names and decode HTML entities
        $categoryMap = array_column($categories, 'name', 'id');
        $categoryMap = array_map('html_entity_decode', $categoryMap);

        // Filter posts and sort by date descending (newest first)
        $pengumumanPosts = array_filter($allPosts, function($post) {
            return is_array($post) && in_array(87, $post['categories'] ?? []);
        });

        $beritaPosts = array_filter($allPosts, function($post) {
            return is_array($post) && !in_array(87, $post['categories'] ?? []) && !in_array(88, $post['categories'] ?? []);
        });

        // Sort posts by date (newest first)
        usort($pengumumanPosts, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        usort($beritaPosts, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        Log::info('Filtered Pengumuman Count:', [count($pengumumanPosts)]);
        Log::info('Filtered Berita Count:', [count($beritaPosts)]);

        // Get the 6 newest posts
        $latestPengumumanPosts = array_slice($pengumumanPosts, 0, 6);
        $latestBeritaPosts = array_slice($beritaPosts, 0, 6);

        Log::info('Sliced Pengumuman Posts Count:', [count($latestPengumumanPosts)]);
        Log::info('Sliced Berita Posts Count:', [count($latestBeritaPosts)]);

        // Process posts for display
        foreach ($latestPengumumanPosts as &$post) {
            $post['categories'] = array_map(fn($id) => $categoryMap[$id] ?? 'Uncategorized', $post['categories'] ?? []);
            $post['title']['rendered'] = html_entity_decode($post['title']['rendered'] ?? 'Untitled', ENT_QUOTES, 'UTF-8');
            $post['excerpt'] = $this->generateExcerpt($post['content']['rendered'] ?? '');
        }

        foreach ($latestBeritaPosts as &$post) {
            $post['categories'] = array_map(fn($id) => $categoryMap[$id] ?? 'Uncategorized', $post['categories'] ?? []);
            $post['title']['rendered'] = html_entity_decode($post['title']['rendered'] ?? 'Untitled', ENT_QUOTES, 'UTF-8');
            $post['excerpt'] = $this->generateExcerpt($post['content']['rendered'] ?? '');
        }

        // Fetch campaigns
        $campaigns = $this->fetchAndProcessCampaigns();

        return view('landing.home', [
            'latestPengumumanPosts' => $latestPengumumanPosts,
            'latestBeritaPosts' => $latestBeritaPosts,
            'campaigns' => $campaigns
        ]);
    }

    private function fetchAllPosts()
    {
        $response = Http::get('https://rumahamal.usk.ac.id/api/wp-json/wp/v2/posts', [
            'orderby' => 'date',
            'order' => 'desc',
            'per_page' => 50 // Increased to get more posts for filtering
        ]);

        $posts = $response->json();
        if (!is_array($posts)) {
            abort(500, 'Failed to fetch posts.');
        }

        return array_map(function ($post) {
            return [
                'id' => $post['id'] ?? 0,
                'slug' => $post['slug'] ?? '',
                'image_url' => $this->extractImageUrl($post),
                'categories' => $post['categories'] ?? [],
                'title' => $post['title'] ?? [],
                'content' => $post['content'] ?? [],
                'link' => $post['link'] ?? '',
                'date' => $post['date'] ?? ''
            ];
        }, $posts);
    }

    private function fetchCategories()
    {
        $response = Http::get('https://rumahamal.usk.ac.id/api/wp-json/wp/v2/categories');
        $categories = $response->json();
        if (!is_array($categories)) {
            abort(500, 'Failed to fetch categories.');
        }

        return array_map(function ($category) {
            return [
                'id' => $category['id'] ?? 0,
                'name' => $category['name'] ?? 'Unknown',
                'slug' => $category['slug'] ?? '',
            ];
        }, $categories);
    }

    private function fetchAndProcessCampaigns()
    {
        $response = Http::get('https://rumahamal.usk.ac.id/api/wp-json/wp/v2/campaign_unggulan');
        if (!$response->ok()) {
            abort(500, 'Failed to fetch campaigns.');
        }

        $campaigns = $response->json();
        if (!is_array($campaigns)) {
            abort(500, 'Invalid data format for campaigns.');
        }

        $processedCampaigns = array_map(function ($campaign) {
            $terkumpul = $campaign['acf']['dana_terkumpul'] ?? 0;
            $dibutuhkan = $campaign['acf']['jumlah_dana'] ?? 1;
            $percentage = ($dibutuhkan > 0) ? ($terkumpul / $dibutuhkan) * 100 : 0;
            $category = strtolower($campaign['type'] ?? 'uncategorized');

            $doc = new DOMDocument();
            libxml_use_internal_errors(true);
            $doc->loadHTML($campaign['content']['rendered']);
            libxml_clear_errors();
            $imgTags = $doc->getElementsByTagName('img');
            $image = $imgTags->length > 0 ? $imgTags->item(0)->getAttribute('src') : '';

            $campaign['terkumpul'] = $terkumpul;
            $campaign['dibutuhkan'] = $dibutuhkan;
            $campaign['percentage'] = $percentage;
            $campaign['category'] = $category;
            $campaign['image'] = $image;

            return $campaign;
        }, $campaigns);

        return array_slice($processedCampaigns, 0, 6);
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

    private function generateExcerpt($content, $length = 100)
    {
        $content = strip_tags($content);
        $content = html_entity_decode($content, ENT_QUOTES, 'UTF-8');
        return substr($content, 0, $length) . (strlen($content) > $length ? '...' : '');
    }
}