<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PengumumanController extends Controller
{
    private $pengumumanCategoryId = 87; // Category ID for Pengumuman

    public function show($id)
    {
        // Fetch the post details
        $response = Http::get('http://rumahamal.usk.ac.id/api/wp-json/wp/v2/posts/' . $id);
    
        if ($response->successful()) {
            $pengumuman = $response->json();
    
            // Extract images from the post content
            preg_match_all('/<img[^>]+src="([^">]+)"/', $pengumuman['content']['rendered'], $matches);
            $images = array_unique($matches[1]);
    
            // Set the main image
            $mainImage = $images[0] ?? asset('assets/img/default.jpeg');
    
            // Remove the main image from the content
            $filteredContent = str_replace('<img src="' . $mainImage . '"', '', $pengumuman['content']['rendered']);
    
            // Fetch recent posts
            $recent_posts_response = Http::get('http://rumahamal.usk.ac.id/api/wp-json/wp/v2/posts', [
                'per_page' => 5,
            ]);
            $recent_posts = $recent_posts_response->json();
    
            // Add image_url to each recent post
            foreach ($recent_posts as &$post) {
                $post['image_url'] = $this->extractImageUrl($post['content']['rendered']) ?? asset('assets/img/default.jpeg');
            }
    
            // Fetch all tags
            $tags_response = Http::get('http://rumahamal.usk.ac.id/api/wp-json/wp/v2/tags');
            $tags = $tags_response->json();
    
            return view('pengumuman.detail-pengumuman', compact('pengumuman', 'recent_posts', 'tags', 'mainImage', 'filteredContent'));
        } else {
            abort(404, 'Pengumuman tidak ditemukan');
        }
    }

    private function extractImageUrl($content)
    {
        preg_match('/<img[^>]+src="([^">]+)"/', $content, $matches);
        return $matches[1] ?? url('assets/img/default.jpeg');
    }
}