<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use DOMDocument;

class HomeController extends Controller
{
    public function index()
    {
        // Authentication check
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

        // Cache hero slides for 1 hour with versioned key
        $heroSlides = Cache::remember('hero_slides:v1', now()->addHours(1), function() {
            return $this->fetchHeroSlides();
        });

        // Extract image URLs for preloading
        $heroImages = collect($heroSlides)->pluck('image_url')->filter()->toArray();

        // Cache categories for 6 hours (changes less frequently)
        $categories = Cache::remember('categories:v1', now()->addHours(6), function() {
            return $this->fetchCategories();
        });

        // Cache posts for 1 hour
        $allPosts = Cache::remember('all_posts:v1', now()->addHours(1), function() {
            return $this->fetchAllPosts();
        });

        if (!is_array($categories) || !is_array($allPosts)) {
            abort(500, 'Invalid data received from API.');
        }

        // Process categories
        $categoryMap = array_column($categories, 'name', 'id');
        $categoryMap = array_map('html_entity_decode', $categoryMap);

        // Filter and sort posts
        $pengumumanPosts = array_filter($allPosts, function($post) {
            return is_array($post) && in_array(87, $post['categories'] ?? []);
        });

        $beritaPosts = array_filter($allPosts, function($post) {
            return is_array($post) && !in_array(87, $post['categories'] ?? []) && !in_array(88, $post['categories'] ?? []);
        });

        // Sort by date (newest first)
        usort($pengumumanPosts, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        usort($beritaPosts, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        // Get latest posts
        $latestPengumumanPosts = array_slice($pengumumanPosts, 0, 6);
        $latestBeritaPosts = array_slice($beritaPosts, 0, 6);

        // Process post data
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

        // Cache campaigns for 2 hours
        $campaigns = Cache::remember('campaigns:v1', now()->addHours(2), function() {
            return $this->fetchAndProcessCampaigns();
        });

        return view('landing.home', [
            'heroSlides' => $heroSlides,
            'heroImages' => $heroImages,
            'latestPengumumanPosts' => $latestPengumumanPosts,
            'latestBeritaPosts' => $latestBeritaPosts,
            'campaigns' => $campaigns
        ]);
    }

    private function fetchHeroSlides()
    {
        try {
            $response = Http::get('https://rumahamal.usk.ac.id/api/wp-json/wp/v2/carausel?_fields=id,slug,acf');
            $carouselItems = $response->json();
            
            if (!is_array($carouselItems)) {
                return [];
            }

            $slides = [];
            
            foreach ($carouselItems as $item) {
                // Build proper URL from slug
                $link = str_replace(
                    'https-rumahamal-usk-ac-id-berita-', 
                    'https://rumahamal.usk.ac.id/berita/',
                    $item['slug']
                );
                
                // Get image URL if available in ACF
                $imageUrl = null;
                if (!empty($item['acf']['image'])) {
                    $mediaResponse = Http::get("https://rumahamal.usk.ac.id/api/wp-json/wp/v2/media/{$item['acf']['image']}");
                    if ($mediaResponse->successful()) {
                        $mediaData = $mediaResponse->json();
                        $imageUrl = $mediaData['source_url'] ?? null;
                    }
                }

                $slides[] = [
                    'id' => $item['id'],
                    'slug' => $item['slug'],
                    'image_url' => $imageUrl,
                    'title' => $this->extractTitleFromSlug($item['slug']),
                    'link' => $link,
                    'priority' => $item['acf']['priority'] ?? 0
                ];
            }

            // Sort by priority
            usort($slides, function($a, $b) {
                return $a['priority'] <=> $b['priority'];
            });

            return $slides;

        } catch (\Exception $e) {
            Log::error('Error fetching hero slides: ' . $e->getMessage());
            return [];
        }
    }

    private function extractTitleFromSlug($slug)
    {
        // Remove prefix and replace hyphens with spaces
        $title = str_replace(['https-rumahamal-usk-ac-id-berita-', '-'], ['', ' '], $slug);
        return ucwords($title);
    }

    private function fetchAllPosts()
    {
        $response = Http::get('https://rumahamal.usk.ac.id/api/wp-json/wp/v2/posts', [
            'orderby' => 'date',
            'order' => 'desc',
            'per_page' => 50
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