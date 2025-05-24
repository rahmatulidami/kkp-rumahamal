<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use DOMDocument;
use DOMElement;

class GalleryController extends Controller
{
    public function showGallery()
    {
        // Use cache for the API response (1 hour cache duration)
        $data = Cache::remember('gallery_page_4716', 60, function () {
            $response = Http::get('https://rumahamal.usk.ac.id/api/wp-json/wp/v2/pages/4716');

            if (!$response->ok()) {
                abort(500, 'Failed to fetch gallery data.');
            }
            
            return $response->json();
        });

        $content = $data['content']['rendered'] ?? '';

        $dom = new DOMDocument();
        @$dom->loadHTML($content);

        $images = [];

        foreach ($dom->getElementsByTagName('a') as $anchor) {
            if (!$anchor instanceof DOMElement) continue;

            $href = $anchor->getAttribute('href'); // Ambil href sebagai full image URL
            $imgTag = $anchor->getElementsByTagName('img')->item(0);

            if ($imgTag instanceof DOMElement) {
                $src = $imgTag->getAttribute('src');
                $alt = $imgTag->getAttribute('alt') ?: 'Image';
                $caption = '';

                // Gunakan href jika ada, fallback ke src setelah membersihkan skala kecil
                $finalSrc = !empty($href) ? $href : preg_replace('/-\d+x\d+| -scaled/', '', $src);

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
                    'src' => $finalSrc, // Gunakan full image URL
                    'href' => $href,
                    'alt' => $alt,
                    'caption' => $caption,
                ];
            }
        }

        // Pagination 
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

        return view('galeri.galeri', [
            'images' => $paginatedImages,
            'pagination' => $pagination
        ]);
    }
}