<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use DOMDocument;
use DOMElement;

class GalleryController extends Controller
{
    public function showGallery()
    {
        // Fetch the JSON data from the API
        $response = Http::get('https://rumahamal.usk.ac.id/api/wp-json/wp/v2/pages/4716');
    
        // Check if the response is successful
        if (!$response->ok()) {
            abort(500, 'Failed to fetch gallery data.');
        }
    
        $data = $response->json();
        $content = $data['content']['rendered'] ?? '';
    
        // Use DOMDocument to parse the HTML content
        $dom = new DOMDocument();
        @$dom->loadHTML($content);
    
        $images = [];
    
        // Get all <a> tags that contain the images
        foreach ($dom->getElementsByTagName('a') as $anchor) {
            if (!$anchor instanceof DOMElement) continue;
    
            $href = $anchor->getAttribute('href');
            $imgTag = $anchor->getElementsByTagName('img')->item(0);
    
            if ($imgTag instanceof DOMElement) {
                $src = $imgTag->getAttribute('src');
                $alt = $imgTag->getAttribute('alt') ?: 'Image';
                $caption = '';
    
                $nextElement = $anchor->nextSibling;
                while ($nextElement) {
                    if ($nextElement instanceof DOMElement) {
                        if ($nextElement->nodeName === 'div' && $nextElement->getAttribute('class') === 'gallery-caption__wrapper') {
                            $captionTag = $nextElement->getElementsByTagName('dd')->item(0);
                            if ($captionTag instanceof DOMElement) {
                                $caption = trim($captionTag->textContent);
                            }
                            break;
                        }
                    }
                    $nextElement = $nextElement->nextSibling;
                }
    
                if (empty($caption)) {
                    foreach ($dom->getElementsByTagName('dd') as $captionTag) {
                        if ($captionTag instanceof DOMElement && $captionTag->getAttribute('class') === 'wp-caption-text gallery-caption') {
                            $caption = trim($captionTag->textContent);
                            break;
                        }
                    }
                }
    
                $images[] = [
                    'src' => $src,
                    'href' => $href,
                    'alt' => $alt,
                    'caption' => $caption,
                ];
            }
        }
    
        // Pagination setup
        $perPage = 8;
        $totalImages = count($images);
        $totalPages = ceil($totalImages / $perPage);
        $currentPage = request()->query('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $paginatedImages = array_slice($images, $offset, $perPage);
    
        $pagination = [
            'current_page' => $currentPage,
            'total_pages' => $totalPages
        ];
    
        // Pass the images and pagination data to the view
        return view('galeri.galeri', [
            'images' => $paginatedImages,
            'pagination' => $pagination
        ]);
    }
    
}
