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
            $response = Http::get("https://rumahamal.usk.ac.id/wp-json/wp/v2/pages/4729?cp={$cp}");

            if ($response->ok()) {
                $data = $response->json();
                $htmlContent = $data['content']['rendered'];

                // Load the HTML content into a DOM parser
                $dom = new \DOMDocument();
                @$dom->loadHTML($htmlContent);

                // Find all <a> tags within the content
                $links = $dom->getElementsByTagName('a');
                $foundDocuments = false;

                foreach ($links as $link) {
                    $downloadUrl = $link->getAttribute('data-downloadurl');

                    if ($downloadUrl) {
                        $foundDocuments = true;
                        $documentName = trim($link->nodeValue);
                        $fileType = pathinfo($downloadUrl, PATHINFO_EXTENSION);

                        // Set the icon URL based on the file type
                        $iconUrl = "https://rumahamal.usk.ac.id/wp-content/plugins/download-manager/assets/file-type-icons/{$fileType}.svg";

                        // Append the document data to the list
                        $documents[] = [
                            'name' => $documentName,
                            'type' => $fileType,
                            'icon' => $iconUrl,
                            'download' => $downloadUrl,
                        ];
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
