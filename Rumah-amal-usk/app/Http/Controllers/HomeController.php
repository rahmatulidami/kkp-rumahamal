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
    
        // Fetch the latest 5 posts for the hero section without any category restrictions
        $latestHeroPosts = $this->fetchAllPosts(5, true);
    
        // Fetch all posts for filtering into "Berita Terkini" and "Pengumuman"
        $allPosts = $this->fetchAllPosts();
    
        // Check if categories and posts are arrays
        if (!is_array($categories) || !is_array($allPosts) || !is_array($latestHeroPosts)) {
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
            return is_array($post) && !in_array(87, $post['categories'] ?? []) && !in_array(88, $post['categories'] ?? []);
        });
    
        usort($pengumumanPosts, fn($a, $b) => strtotime($b['date'] ?? '1970-01-01') - strtotime($a['date'] ?? '1970-01-01'));
        usort($beritaPosts, fn($a, $b) => strtotime($b['date'] ?? '1970-01-01') - strtotime($a['date'] ?? '1970-01-01'));
    
        $latestPengumumanPosts = array_slice($pengumumanPosts, 0, 3);
        $latestBeritaPosts = array_slice($beritaPosts, 0, 3);
    
        // Replace category IDs with names and decode HTML entities
        foreach ($latestPengumumanPosts as &$post) {
            $post['categories'] = array_map(fn($id) => $categoryMap[$id] ?? 'Uncategorized', $post['categories'] ?? []);
            $post['title']['rendered'] = html_entity_decode($post['title']['rendered'] ?? 'Untitled', ENT_QUOTES, 'UTF-8');
        }
    
        foreach ($latestBeritaPosts as &$post) {
            $post['categories'] = array_map(fn($id) => $categoryMap[$id] ?? 'Uncategorized', $post['categories'] ?? []);
            $post['title']['rendered'] = html_entity_decode($post['title']['rendered'] ?? 'Untitled', ENT_QUOTES, 'UTF-8');
        }
    
        // Fetch campaigns and program posts
        $campaigns = $this->fetchAndProcessCampaigns();
        $programPosts = $this->fetchProgramPosts();
    
        // Return the home view with the latest posts, categories, campaigns, and program posts
        return view('landing.home', [
            'latestPosts' => $latestHeroPosts, // Use this for the hero section
            'latestPengumumanPosts' => $latestPengumumanPosts,
            'latestBeritaPosts' => $latestBeritaPosts, // Use this for "Berita Terkini"
            'campaigns' => $campaigns,
            'programPosts' => $programPosts
        ]);
    }
    
    private function fetchAllPosts($limit = null, $heroOnly = false)
    {
        $params = ['orderby' => 'date', 'order' => 'desc'];
        if ($limit) {
            $params['per_page'] = $limit;
        }
    
        $response = Http::get('http://rumahamal.usk.ac.id/api/wp-json/wp/v2/posts', $params);
    
        $posts = $response->json();
        if (!is_array($posts)) {
            abort(500, 'Failed to fetch posts.');
        }
    
        // Filter posts based on category ID 101 for hero section
        if ($heroOnly) {
            $posts = array_filter($posts, function ($post) {
                return in_array(101, $post['categories'] ?? []);
            });
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

    private function fetchCategories()
    {
        $response = Http::get('http://rumahamal.usk.ac.id/api/wp-json/wp/v2/categories');

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

    private function fetchAndProcessCampaigns()
    {
        $response = Http::get('https://rumahamal.usk.ac.id/api/wp-json/wp/v2/campaign_unggulan');

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
        $response = Http::get('https://rumahamal.usk.ac.id/api/wp-json/wp/v2/posts/?per_page=100&_embed');
    
        if (!$response->ok()) {
            abort(500, 'Failed to fetch program posts.');
        }
    
        $posts = $response->json();
    
        // Filter out posts with category ID 87, 52, or 88
        $filteredPosts = array_filter($posts, function ($post) {
            $categories = $post['categories'] ?? [];
            return !in_array(87, $categories) && !in_array(52, $categories) && !in_array(88, $categories);
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
            $mediaResponse = Http::get("https://rumahamal.usk.ac.id/api/wp-json/wp/v2/media/{$mediaId}");
    
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
