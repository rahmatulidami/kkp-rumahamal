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
        $latestPosts = $this->fetchAllPosts();
        $campaigns = $this->fetchAndProcessCampaigns();
        $programPosts = $this->fetchProgramPosts();

        // Check if categories and posts are arrays
        if (!is_array($categories) || !is_array($latestPosts)) {
            abort(500, 'Invalid data received from API.');
        }

        // Map category IDs to names and decode HTML entities
        $categoryMap = array_column($categories, 'name', 'id');
        $categoryMap = array_map('html_entity_decode', $categoryMap);

        // Filter and sort posts
        $pengumumanPosts = array_filter($latestPosts, function($post) {
            return is_array($post) && in_array(87, $post['categories'] ?? []);
        });

        $beritaPosts = array_filter($latestPosts, function($post) {
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

        // Return the home view with the latest posts, categories, campaigns, and program posts
        return view('landing.home', [
            'latestPosts' => $latestPosts,
            'latestPengumumanPosts' => $latestPengumumanPosts,
            'latestBeritaPosts' => $latestBeritaPosts,
            'campaigns' => $campaigns,
            'programPosts' => $programPosts
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
        $response = Http::get('http://rumahamal.usk.ac.id/wp-json/wp/v2/posts', ['per_page' => 6, 'orderby' => 'date', 'order' => 'desc']);

        $posts = $response->json();
        if (!is_array($posts)) {
            abort(500, 'Failed to fetch posts.');
        }

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

    private function fetchAndProcessCampaigns()
    {
        $response = Http::get('https://rumahamal.usk.ac.id/wp-json/wp/v2/campaign_unggulan');

        // Check if the response is valid
        if (!$response->ok()) {
            abort(500, 'Failed to fetch campaigns.');
        }

        $campaigns = $response->json();

        // Check if campaigns is an array
        if (!is_array($campaigns)) {
            abort(500, 'Invalid data format for campaigns.');
        }

        // Process campaigns to extract image URLs and other details
        $processedCampaigns = array_map(function ($campaign) {
            $terkumpul = $campaign['acf']['dana_terkumpul'] ?? 0;
            $dibutuhkan = $campaign['acf']['jumlah_dana'] ?? 1; // Avoid division by zero
            $percentage = ($dibutuhkan > 0) ? ($terkumpul / $dibutuhkan) * 100 : 0;
            $category = strtolower($campaign['type'] ?? 'uncategorized');

            // Extract image URL from content.rendered
            $doc = new DOMDocument();
            libxml_use_internal_errors(true);
            $doc->loadHTML($campaign['content']['rendered']);
            libxml_clear_errors();
            $imgTags = $doc->getElementsByTagName('img');
            $image = $imgTags->length > 0 ? $imgTags->item(0)->getAttribute('src') : '';

            // Add new fields to the campaign array
            $campaign['terkumpul'] = $terkumpul;
            $campaign['dibutuhkan'] = $dibutuhkan;
            $campaign['percentage'] = $percentage;
            $campaign['category'] = $category;
            $campaign['image'] = $image;

            return $campaign;
        }, $campaigns);

        // Slice to get the first 6 campaigns
        return array_slice($processedCampaigns, 0, 6);
    }

    private function fetchProgramPosts()
    {
        $response = Http::get('https://rumahamal.usk.ac.id/wp-json/wp/v2/posts/?per_page=100&_embed');

        // Check if the response is valid
        if (!$response->ok()) {
            abort(500, 'Failed to fetch program posts.');
        }

        $posts = $response->json();

        // Filter out posts with 'berita' or 'pengumuman' categories
        $filteredPosts = array_filter($posts, function ($post) {
            $categories = $post['categories'] ?? [];
            // Only include posts that do not have category ID 87 or 52
            return !in_array(87, $categories) && !in_array(52, $categories);
        });

        return array_map(function ($post) {
            $imageUrl = $this->extractProgramImageUrl($post);
            return [
                'id' => $post['id'] ?? 0,
                'image_url' => $imageUrl,
                'categories' => $post['categories'] ?? [],
                'title' => $post['title']['rendered'] ?? 'Untitled',
                'link' => $post['link'] ?? '#',
                'date' => $post['date'] ?? ''
            ];
        }, $filteredPosts);
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

    private function extractProgramImageUrl($post)
    {
        // Check if featured_media is set and fetch the media details
        if (isset($post['featured_media']) && is_numeric($post['featured_media'])) {
            $mediaId = $post['featured_media'];
            $mediaResponse = Http::get("https://rumahamal.usk.ac.id/wp-json/wp/v2/media/{$mediaId}");
    
            // Log the response for debugging
            Log::info('Media Response: ', ['mediaId' => $mediaId, 'response' => $mediaResponse->json()]);
    
            // Check if the response is valid
            if ($mediaResponse->ok()) {
                $media = $mediaResponse->json();
    
                // Check if media details have a valid image URL in description.rendered
                if (isset($media['description']['rendered'])) {
                    $description = $media['description']['rendered'];
    
                    // Use DOMDocument to parse the description HTML and extract the image URL
                    $doc = new DOMDocument();
                    libxml_use_internal_errors(true);
                    $doc->loadHTML($description);
                    libxml_clear_errors();
    
                    $imgTags = $doc->getElementsByTagName('img');
                    if ($imgTags->length > 0) {
                        $imageUrl = $imgTags->item(0)->getAttribute('src');
                        return $imageUrl;
                    }
                }
            }
        }
    
        // Fallback to guid.rendered if no valid image URL is found in media
        if (isset($post['guid']['rendered'])) {
            return $post['guid']['rendered'];
        }
    
        // Return a default image if no valid image URL is found
        return url('assets/img/default.jpeg');
    }
    
    
}
