<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class DocumentController extends Controller
{
    public function showDocuments(Request $request)
    {
        $documents = [];
        $cp = 0;
        $maxPages = 10; // Batas maksimal request API

        while ($cp < $maxPages) {

            $response = Http::get("https://rumahamal.usk.ac.id/api/wp-json/wp/v2/pages/4729?cp={$cp}");

            if (!$response->ok()) break; // Hentikan jika request gagal

            $data = $response->json();
            $htmlContent = $data['content']['rendered'] ?? '';
            
            if (empty($htmlContent)) break; // Hentikan jika tidak ada konten

            $dom = new \DOMDocument();
            @$dom->loadHTML($htmlContent);

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
            
                // Pisahkan judul, ukuran (KB), dan jumlah download
                if (preg_match('/(.+?)\s(\d+\.\d+\s*(KB|MB))\s*(\d+)\s*downloads?/i', $cleanedHeading, $matches)) {
                    $documentNames[] = [
                        'title' => trim($matches[1]), // Judul dokumen
                        'size' => $matches[2] ?? null, // Ukuran file (KB/MB)
                        'downloads' => $matches[4] ?? '0', // Jumlah download
                    ];                    
                } else {
                    $documentNames[] = [
                        'title' => $cleanedHeading,
                        'size' => null,
                        'downloads' => null,
                    ];
                }
            }
            
            $documentIndex = 0;
            foreach ($links as $link) {
                if ($link instanceof \DOMElement && $link->hasAttribute('data-downloadurl')) {
                    $downloadUrl = $link->getAttribute('data-downloadurl');
                    if ($downloadUrl) {
                        $foundDocuments = true;
                        $fileType = pathinfo($downloadUrl, PATHINFO_EXTENSION);
                        
                        $documents[] = [
                            'name' => $documentNames[$documentIndex]['title'] ?? 'Dokumen Tanpa Nama',
                            'size' => $documentNames[$documentIndex]['size'] ?? 'Tidak diketahui',
                            'downloads' => $documentNames[$documentIndex]['downloads'] ?? '0 downloads',
                            'type' => $fileType,
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
        $perPage = 8;
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
