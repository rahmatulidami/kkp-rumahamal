<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DocumentController extends Controller
{
    public function showDocuments(Request $request)
    {
        $currentPage = $request->query('page', 1);
        $searchQuery = $request->query('search', ''); // Ambil kata kunci pencarian
        $filter = $request->query('filter', ''); // Ambil filter pilihan

        $cp = $currentPage;

        // Kirim request dengan pencarian dan filter (jika API mendukung)
        $response = Http::get("https://rumahamal.usk.ac.id/api/wp-json/wp/v2/pages/4729", [
            'cp' => $cp,
            'page' => $currentPage,
            'search' => $searchQuery,
            'filter' => $filter // Kirim parameter filter ke API
        ]);

        if (!$response->ok()) {
            return view('galeri.dokumen', [
                'documents' => [],
                'pagination' => ['current_page' => $currentPage, 'total_pages' => 1],
                'searchQuery' => $searchQuery,
                'filter' => $filter
            ]);
        }

        $data = $response->json();
        $htmlContent = $data['content']['rendered'];

        // Parsing dokumen seperti sebelumnya...
        $dom = new \DOMDocument();
        @$dom->loadHTML($htmlContent);
        $links = $dom->getElementsByTagName('a');
        $xpath = new \DOMXPath($dom);
        $headings = $xpath->query("//h3[@class='media-heading']");

        $documentNames = [];
        foreach ($headings as $heading) {
            $cleanedHeading = html_entity_decode(trim($heading->nodeValue), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $cleanedHeading = str_replace(['â', '�'], '-', $cleanedHeading);
            $cleanedHeading = preg_replace('/[^\x20-\x7E]/', '', $cleanedHeading);
            $documentNames[] = $cleanedHeading;
        }

        $documents = [];
        $documentIndex = 0;
        foreach ($links as $link) {
            if ($link instanceof \DOMElement && $link->hasAttribute('data-downloadurl')) {
                $downloadUrl = $link->getAttribute('data-downloadurl');

                if ($downloadUrl) {
                    $fileType = pathinfo($downloadUrl, PATHINFO_EXTENSION);
                    $iconUrl = "https://rumahamal.usk.ac.id/api/wp-content/plugins/download-manager/assets/file-type-icons/{$fileType}.svg";

                    $documents[] = [
                        'name' => $documentNames[$documentIndex] ?? 'Unknown',
                        'type' => $fileType,
                        'icon' => $iconUrl,
                        'download' => $downloadUrl,
                    ];

                    $documentIndex++;
                }
            }
        }

        // Asumsikan total halaman tersedia di API
        $totalPages = 6; // Adjust based on your API response

        return view('galeri.dokumen', [
            'documents' => $documents,
            'pagination' => ['current_page' => $currentPage, 'total_pages' => $totalPages],
            'searchQuery' => $searchQuery,
            'filter' => $filter
        ]);
    }
}
