<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class DocumentController extends Controller
{
    public function showDocuments(Request $request)
    {
        $documents = [];
        $cp = 0;
        $maxPages = 10; // Batas maksimal request API

        while ($cp < $maxPages) {
            // Fetch data from API
            $response = Http::get("https://rumahamal.usk.ac.id/api/wp-json/wp/v2/pages/4729?cp={$cp}");

            if (!$response->ok()) break; // Hentikan jika request gagal

            $data = $response->json();
            $htmlContent = $data['content']['rendered'] ?? '';
            
            if (empty($htmlContent)) break; // Hentikan jika tidak ada konten

            // Load HTML ke DOM parser
            $dom = new \DOMDocument();
            @$dom->loadHTML($htmlContent);

            // Ambil semua elemen <a>
            $links = $dom->getElementsByTagName('a');
            $foundDocuments = false;

            // Ambil semua <h3> dengan class 'media-heading'
            $xpath = new \DOMXPath($dom);
            $headings = $xpath->query("//h3[@class='media-heading']");
            
            $documentNames = [];
            foreach ($headings as $heading) {
                $cleanedHeading = html_entity_decode(trim($heading->nodeValue), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $cleanedHeading = str_replace(['â', '�'], '-', $cleanedHeading);
                $cleanedHeading = preg_replace('/[^\x20-\x7E]/', '', $cleanedHeading);
                $documentNames[] = $cleanedHeading;
            }
            
            $documentIndex = 0;
            foreach ($links as $link) {
                if ($link instanceof \DOMElement && $link->hasAttribute('data-downloadurl')) {
                    $downloadUrl = $link->getAttribute('data-downloadurl');
                    if ($downloadUrl) {
                        $foundDocuments = true;
                        $fileType = pathinfo($downloadUrl, PATHINFO_EXTENSION);
                        $defaultIconUrl = "https://rumahamal.usk.ac.id/api/wp-content/plugins/download-manager/assets/file-type-icons/default.svg";
                        $iconUrl = "https://rumahamal.usk.ac.id/api/wp-content/plugins/download-manager/assets/file-type-icons/{$fileType}.svg";
                        
                        $documents[] = [
                            'name' => $documentNames[$documentIndex] ?? 'Dokumen Tanpa Nama',
                            'type' => $fileType,
                            'icon' => $iconUrl,
                            'download' => $downloadUrl,
                            'created_at' => now()->subDays(rand(1, 365)), // Dummy date untuk sorting
                        ];
                        $documentIndex++;
                    }
                }
            }

            if (!$foundDocuments) break;
            $cp++;
        }

        // Filtering
        $search = $request->query('search');
        $filter = $request->query('filter');
        
        if ($search) {
            $documents = array_values(array_filter($documents, function ($doc) use ($search) {
                return stripos($doc['name'], $search) !== false;
            }));
        }

        // Sorting berdasarkan filter
        usort($documents, function ($a, $b) use ($filter) {
            if ($filter === 'all' || empty($filter)) {
                return 0;
            }
            switch ($filter) {
                case 'name-asc': return strcmp($a['name'], $b['name']);
                case 'name-desc': return strcmp($b['name'], $a['name']);
                case 'date-asc': return strtotime($a['created_at']) - strtotime($b['created_at']);
                case 'date-desc': return strtotime($b['created_at']) - strtotime($a['created_at']);
                case 'type-pdf': return $a['type'] === 'pdf' ? -1 : 1;
                case 'type-doc': return $a['type'] === 'doc' ? -1 : 1;
                case 'type-csv': return $a['type'] === 'csv' ? -1 : 1;
                default: return 0;
            }
        });

        // Pagination
        $perPage = 12;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $documentsCollection = collect($documents);
        $currentPageDocuments = $documentsCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $pagination = new LengthAwarePaginator($currentPageDocuments, count($documents), $perPage, $currentPage);

        return view('galeri.dokumen', [
            'documents' => $pagination->items(),
            'pagination' => [
                'current_page' => $pagination->currentPage(),
                'total_pages' => $pagination->lastPage(),
            ]
        ]);
    }
}
