<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PengumumanController extends Controller
{
    private $apiBaseUrl = 'http://rumahamal.usk.ac.id/api/wp-json/wp/v2';
    private $pengumumanCategoryId = 87; // Category ID for Pengumuman

    public function show($slug)
    {
        $postDetails = $this->fetchPostBySlug($slug);

        if ($postDetails) {
            $pengumuman = $postDetails[0]; // Get the first post from the response

            $pengumuman['title']['rendered'] = $this->cleanTitle($pengumuman['title']['rendered']);
            $mainImage = $this->getMainImage($pengumuman['content']['rendered']);
            $filteredContent = $this->filterContent($pengumuman['content']['rendered'], $mainImage);

            $recent_posts = $this->fetchRecentPosts();
            $tags = $this->fetchAllTags();

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
        $response = Http::get("{$this->apiBaseUrl}/posts", [
            'per_page' => 5,
        ]);
        $recent_posts = $response->json();
        
        foreach ($recent_posts as &$post) {
            $post['title']['rendered'] = $this->cleanTitle($post['title']['rendered']);
            $post['image_url'] = $this->extractImageUrl($post['content']['rendered']) ?? asset('assets/img/default.jpeg');
        }

        return $recent_posts;
    }

    private function fetchAllTags()
    {
        $response = Http::get("{$this->apiBaseUrl}/tags");
        return $response->json();
    }

    private function extractImageUrl($content)
    {
        preg_match('/<img[^>]+src="([^">]+)"/', $content, $matches);
        return $matches[1] ?? url('assets/img/default.jpeg');
    }

    private function cleanTitle($title)
    {
        $title = html_entity_decode($title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $title = str_replace(["&#8217;", "&amp;"], ["'", "&"], $title);
        return trim($title);
    }

    private function getMainImage($content)
    {
        preg_match_all('/<img[^>]+src="([^">]+)"/', $content, $matches);
        return $matches[1][0] ?? asset('assets/img/default.jpeg');
    }

    private function filterContent($content, $mainImage)
    {
        return str_replace('<img src="' . $mainImage . '"', '', $content);
    }
}
