<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PengumumanController extends Controller
{
    private $apiBaseUrl = 'http://rumahamal.usk.ac.id/api/wp-json/wp/v2';
    private $pengumumanCategoryId = 87; // Category ID for Pengumuman
    private $cacheTime = 60 * 60; // Cache time in seconds (e.g., 1 hour)

    public function show($slug)
    {
        $postDetails = $this->fetchPostBySlug($slug);

        if ($postDetails) {
            $pengumuman = $postDetails[0]; // Get the first post from the response

            // Clean the title and extract the main image
            $pengumuman['title']['rendered'] = $this->cleanTitle($pengumuman['title']['rendered']);
            $mainImage = $this->getMainImage($pengumuman['content']['rendered']);

            // Filter the content and remove the main image tag
            $filteredContent = $this->filterContent($pengumuman['content']['rendered'], $mainImage);

            // Fetch recent posts and tags
            $recent_posts = $this->fetchRecentPosts();
            $tags = $this->fetchAllTags();

            // Return the view with the necessary data
            return view('pengumuman.detail-pengumuman', compact('pengumuman', 'recent_posts', 'tags', 'mainImage', 'filteredContent'));
        } else {
            abort(404, 'Pengumuman tidak ditemukan');
        }
    }

    private function fetchPostBySlug($slug)
    {
        $response = Http::get("{$this->apiBaseUrl}/posts", [
            'slug' => $slug,
        ]);
        return $response->successful() ? $response->json() : null;
    }

    private function fetchRecentPosts()
    {
        // Caching recent posts for performance optimization
        return Cache::remember('recent_posts', $this->cacheTime, function() {
            $response = Http::get("{$this->apiBaseUrl}/posts", [
                'per_page' => 5,
            ]);
            $recent_posts = $response->json();
            
            foreach ($recent_posts as &$post) {
                $post['title']['rendered'] = $this->cleanTitle($post['title']['rendered']);
                $post['image_url'] = $this->extractImageUrl($post['content']['rendered']) ?? asset('assets/img/default.jpeg');
            }

            return $recent_posts;
        });
    }

    private function fetchAllTags()
    {
        // Caching tags to improve performance
        return Cache::remember('tags', $this->cacheTime, function() {
            $response = Http::get("{$this->apiBaseUrl}/tags");
            return $response->json();
        });
    }

    private function extractImageUrl($content)
    {
        // Extract the first image URL from the content if available
        preg_match('/<img[^>]+src="([^">]+)"/', $content, $matches);
        return $matches[1] ?? url('assets/img/default.jpeg'); // Fallback to default image if no image is found
    }

    private function cleanTitle($title)
    {
        // Clean unwanted characters from the title
        $title = html_entity_decode($title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $title = str_replace(["&#8217;", "&amp;"], ["'", "&"], $title);
        return trim($title);
    }

    private function getMainImage($content)
    {
        // Extract the main image from the content
        preg_match_all('/<img[^>]+src="([^">]+)"/', $content, $matches);
        return $matches[1][0] ?? asset('assets/img/default.jpeg'); // Fallback to default image if no image is found
    }

    private function filterContent($content, $mainImage)
    {
        // Remove the main image from the content to avoid duplicating it in the post body
        return str_replace('<img src="' . $mainImage . '"', '', $content);
    }
}
