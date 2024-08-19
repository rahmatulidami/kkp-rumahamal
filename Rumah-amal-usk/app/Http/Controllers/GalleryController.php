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
        $data = $response->json();

        // Extract the content
        $content = $data['content']['rendered'];

        // Use DOMDocument to parse the HTML content
        $dom = new DOMDocument();
        @$dom->loadHTML($content);

        $images = [];

        // Get all <a> tags that contain the images
        foreach ($dom->getElementsByTagName('a') as $anchor) {
            $href = $anchor->getAttribute('href'); // High-resolution image URL
            $imgTag = $anchor->getElementsByTagName('img')->item(0);

            if ($imgTag instanceof DOMElement) {
                $src = $imgTag->getAttribute('src');
                $alt = $imgTag->getAttribute('alt');
                $caption = '';

                // Find the corresponding caption
                $nextElement = $anchor->nextSibling;
                while ($nextElement) {
                    if ($nextElement->nodeType === XML_ELEMENT_NODE) {
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

                // Handle case where caption is directly in <dd> tags
                if (empty($caption)) {
                    foreach ($dom->getElementsByTagName('dd') as $captionTag) {
                        if ($captionTag->getAttribute('class') === 'wp-caption-text gallery-caption') {
                            $caption = trim($captionTag->textContent);
                            break;
                        }
                    }
                }

                $images[] = [
                    'src' => $src,
                    'href' => $href, // This should be the high-res image URL
                    'alt' => $alt,
                    'caption' => $caption,
                ];
            }
        }

        // Pass the images array to the view
        return view('galeri.galeri', ['images' => $images]);
    }
}
