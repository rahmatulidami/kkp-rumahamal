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

        $heroSlides = Cache::remember('hero_slides:v1', now()->addMinutes(15), function() {
            return $this->fetchHeroSlides();
        });

        $heroImages = collect($heroSlides)->pluck('image_url')->filter()->toArray();

        $categories = Cache::remember('categories:v1', now()->addMinutes(15), function() {
            return $this->fetchCategories();
        });

        $allPosts = Cache::remember('all_posts:v1', now()->addMinutes(15), function() {
            return $this->fetchAllPosts();
        });

        if (!is_array($categories) || !is_array($allPosts)) {
            abort(500, 'Invalid data received from API.');
        }

        $categoryMap = array_column($categories, 'name', 'id');
        $categoryMap = array_map('html_entity_decode', $categoryMap);

        $pengumumanPosts = array_filter($allPosts, function($post) {
            return is_array($post) && in_array(87, $post['categories'] ?? []);
        });

        $beritaPosts = array_filter($allPosts, function($post) {
            return is_array($post) && !in_array(87, $post['categories'] ?? []) && !in_array(88, $post['categories'] ?? []);
        });

        usort($pengumumanPosts, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        usort($beritaPosts, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        $latestPengumumanPosts = array_slice($pengumumanPosts, 0, 6);
        $latestBeritaPosts = array_slice($beritaPosts, 0, 6);

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

        $campaigns = Cache::remember('campaigns:v1', now()->addMinutes(15), function() {
            return $this->fetchAndProcessCampaigns();
        });
        $newsletterImages = Cache::remember('newsletters:v1', now()->addMinutes(1), function() {
            return $this->fetchNewsletters();
        });

        return view('landing.home', [
            'heroSlides' => $heroSlides,
            'heroImages' => $heroImages,
            'latestPengumumanPosts' => $latestPengumumanPosts,
            'latestBeritaPosts' => $latestBeritaPosts,
            'campaigns' => $campaigns,
            'newsletterImages' => $newsletterImages
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
                $imageUrl = null;
                // Selalu coba ambil gambar jika ada ID di acf.image
                if (isset($item['acf']['image']) && !empty($item['acf']['image'])) {
                    $mediaResponse = Http::get("https://rumahamal.usk.ac.id/api/wp-json/wp/v2/media/{$item['acf']['image']}");
                    if ($mediaResponse->successful()) {
                        $mediaData = $mediaResponse->json();
                        $imageUrl = $mediaData['source_url'] ?? null;
                    } else {
                        // Log jika gagal mengambil media, tapi jangan menghentikan proses
                        Log::warning("Gagal mengambil media untuk ID: {$item['acf']['image']}. Status: {$mediaResponse->status()}");
                    }
                }
                // Berikan gambar default jika imageUrl masih null
                if (!$imageUrl) {
                    $imageUrl = url('assets/img/default_carousel.jpeg'); // Pastikan path ini benar
                }

                $link = null;
                // Logika penentuan link tetap sama, bergantung pada slug
                if (!empty($item['slug'])) {
                    if (strpos($item['slug'], 'https-rumahamal-usk-ac-id-berita-') === 0) {
                        $link = str_replace(
                            'https-rumahamal-usk-ac-id-berita-', 
                            'https://rumahamal.usk.ac.id/berita/',
                            $item['slug']
                        );
                    } elseif (strpos($item['slug'], 'https-rumahamal-usk-ac-id-pengumuman-') === 0) {
                        $link = str_replace(
                            'https-rumahamal-usk-ac-id-pengumuman-', 
                            'https://rumahamal.usk.ac.id/pengumuman/',
                            $item['slug']
                        );
                    } elseif (strpos($item['slug'], 'https-rumahamal-usk-ac-id-campaign-') === 0) {
                        $link = str_replace(
                            'https-rumahamal-usk-ac-id-campaign-', 
                            'https://rumahamal.usk.ac.id/campaign/',
                            $item['slug']
                        );
                    }
                    
                    if ($link && !filter_var($link, FILTER_VALIDATE_URL)) {
                        $link = null;
                    }
                }
                
                $slides[] = [
                    'id' => $item['id'],
                    'slug' => $item['slug'],
                    'image_url' => $imageUrl, // Gambar sekarang selalu ada, atau default
                    'title' => $this->extractTitleFromSlug($item['slug']),
                    'link' => $link,
                    'priority' => $item['acf']['priority'] ?? 0,
                    'has_link' => !empty($link)
                ];
            }

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
        $title = str_replace(
            [
                'https-rumahamal-usk-ac-id-berita-', 
                'https-rumahamal-usk-ac-id-pengumuman-',
                'https-rumahamal-usk-ac-id-campaign-',
                '-'
            ], 
            [
                '', 
                '',
                '',
                ' '
            ], 
            $slug
        );
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
        private function fetchNewsletters()
{
    try {
        $response = Http::get('https://rumahamal.usk.ac.id/api/wp-json/wp/v2/newsletter', [
            'per_page' => 3,
            'orderby' => 'date',
            'order' => 'desc',
            '_fields' => 'id,title,content,_links,link,date,featured_media,acf' // Tambahkan acf
        ]);

        if (!$response->ok()) {
            Log::error('Failed to fetch newsletters. Status: ' . $response->status());
            return [];
        }

        $newsletters = $response->json();
        
        if (!is_array($newsletters)) {
            return [];
        }

        $result = [];
        
        foreach ($newsletters as $newsletter) {
            $imageUrl = null;
            
            // 1. Coba ambil dari ACF image jika ada
            if (!empty($newsletter['acf']['image'])) {
                $mediaResponse = Http::get("https://rumahamal.usk.ac.id/api/wp-json/wp/v2/media/{$newsletter['acf']['image']}");
                if ($mediaResponse->ok()) {
                    $mediaData = $mediaResponse->json();
                    $imageUrl = $mediaData['source_url'] ?? null;
                }
            }
            
            // 2. Coba ambil dari attachment
            if (!$imageUrl && isset($newsletter['_links']['wp:attachment'][0]['href'])) {
                $attachmentResponse = Http::get($newsletter['_links']['wp:attachment'][0]['href']);
                
                if ($attachmentResponse->ok()) {
                    $attachments = $attachmentResponse->json();
                    if (!empty($attachments) && isset($attachments[0]['source_url'])) {
                        $imageUrl = $attachments[0]['source_url'];
                    }
                }
            }
            
            // 3. Coba ambil dari konten jika ada
            if (!$imageUrl && isset($newsletter['content']['rendered'])) {
                $doc = new DOMDocument();
                @$doc->loadHTML($newsletter['content']['rendered']);
                $imgTags = $doc->getElementsByTagName('img');
                
                if ($imgTags->length > 0) {
                    $imageUrl = $imgTags->item(0)->getAttribute('src');
                }
            }
            
            // 4. Default image jika semua gagal
            if (!$imageUrl) {
                $imageUrl = url('assets/img/default-newsletter.jpg');
            }
            
            $result[] = [
                'id' => $newsletter['id'] ?? null,
                'title' => html_entity_decode($newsletter['title']['rendered'] ?? 'Untitled Newsletter', ENT_QUOTES, 'UTF-8'),
                'image_url' => $imageUrl,
                'link' => $newsletter['link'] ?? '#',
                'date' => $newsletter['date'] ?? null
            ];
        }

        return $result;

    } catch (\Exception $e) {
        Log::error('Error fetching newsletter images: ' . $e->getMessage());
        return [];
    }
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