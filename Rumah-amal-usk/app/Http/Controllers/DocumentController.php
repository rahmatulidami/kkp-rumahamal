<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DocumentController extends Controller
{
    public function showDocuments()
    {
        $documents = [];
        $cp = 0;

        while (true) {
            // Fetch data from API
            $response = Http::get("https://rumahamal.usk.ac.id/api/wp-json/wp/v2/pages/4729?cp={$cp}");

            if ($response->ok()) {
                $data = $response->json();
                $htmlContent = $data['content']['rendered'];

                // Load the HTML content into a DOM parser
                $dom = new \DOMDocument();
                @$dom->loadHTML($htmlContent);

                // Find all <a> tags within the content
                $links = $dom->getElementsByTagName('a');
                $foundDocuments = false;

                // Find all h3 tags with the class 'media-heading'
                $xpath = new \DOMXPath($dom);
                $headings = $xpath->query("//h3[@class='media-heading']");

                // Create an array to store document names
                $documentNames = [];

                foreach ($headings as $heading) {
                    // Decode HTML entities and trim the string
                    $cleanedHeading = html_entity_decode(trim($heading->nodeValue), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    
                    // Replace unwanted characters
                    $cleanedHeading = str_replace(['â', '�'], '-', $cleanedHeading);
                
                    // Remove non-ASCII characters (e.g., boxes, invalid symbols)
                    $cleanedHeading = preg_replace('/[^\x20-\x7E]/', '', $cleanedHeading);
                
                    // Add the cleaned name to the array
                    $documentNames[] = $cleanedHeading;
                }                

                $documentIndex = 0;

                foreach ($links as $link) {
                    // Ensure $link is a DOMElement and check if the attribute exists
                    if ($link instanceof \DOMElement && $link->hasAttribute('data-downloadurl')) {
                        $downloadUrl = $link->getAttribute('data-downloadurl');

                        if ($downloadUrl) {
                            $foundDocuments = true;
                            $fileType = pathinfo($downloadUrl, PATHINFO_EXTENSION);

                            // Set the icon URL based on the file type
                            $iconUrl = "https://rumahamal.usk.ac.id/api/wp-content/plugins/download-manager/assets/file-type-icons/{$fileType}.svg";

                            // Append the document data to the list, including the name from h3
                            $documents[] = [
                                'name' => $documentNames[$documentIndex] ?? 'Unknown', // Use 'Unknown' if no name is found
                                'type' => $fileType,
                                'icon' => $iconUrl,
                                'download' => $downloadUrl,
                            ];

                            $documentIndex++;
                        }
                    }
                }

                // If no documents are found, stop the loop
                if (!$foundDocuments) {
                    break;
                }

                $cp++; // Increment the page parameter
            } else {
                break; // Stop if the request fails
            }
        }

        return view('galeri.dokumen', ['documents' => $documents]);
    }
}
