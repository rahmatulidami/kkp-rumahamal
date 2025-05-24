<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Carbon\Carbon;


class DocumentController extends Controller
{
    // Cache duration in minutes
    const CACHE_DURATION = 15; 
    
    public function showDocuments(Request $request)
    {
        // Use cache for the API response and document processing
        $cacheKey = 'documents_page_4729_' . md5($request->getQueryString());
        
        $documents = Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($request) {
            $response = Http::timeout(10)->get("https://rumahamal.usk.ac.id/api/wp-json/wp/v2/pages/4729");
            
            if (!$response->ok()) {
                return [];
            }

            $data = $response->json();
            $htmlContent = $data['content']['rendered'] ?? '';
            
            if (empty($htmlContent)) {
                return [];
            }

            return $this->processDocuments($htmlContent);
        });

        // Apply search filter if provided
        $search = $request->query('search');
        if ($search) {
            $documents = array_values(array_filter($documents, function ($doc) use ($search) {
                return stripos($doc['name'], $search) !== false;
            }));
        }

        // Apply sorting
        $filter = $request->query('filter', 'all');
        $documents = $this->sortDocuments($documents, $filter);

        // Paginate results
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
            ],
            'search' => $search,
            'filter' => $filter
        ]);
    }

    /**
     * Process HTML content to extract documents
     */
    protected function processDocuments(string $htmlContent): array
    {
        $documents = [];
        $dom = new \DOMDocument();
        
        // Suppress warnings for malformed HTML
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($htmlContent, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();
        
        $xpath = new \DOMXPath($dom);
        
        // Get all document headings
        $headings = $xpath->query("//h3[@class='media-heading']");
        $documentNames = [];
        
        foreach ($headings as $heading) {
            $cleanedHeading = $this->cleanHeading($heading->nodeValue);
            
            if (preg_match('/(.+?)\s(\d+\.\d+\s*(KB|MB))\s*(\d+)\s*downloads?/i', $cleanedHeading, $matches)) {
                $documentNames[] = [
                    'title' => trim($matches[1]),
                    'size' => $matches[2] ?? null,
                    'downloads' => $matches[4] ?? '0',
                ];                    
            } else {
                $documentNames[] = [
                    'title' => $cleanedHeading,
                    'size' => null,
                    'downloads' => null,
                ];
            }
        }
        
        // Get all download links
        $links = $xpath->query("//a[@data-downloadurl]");
        $documentIndex = 0;
        
        foreach ($links as $link) {
            /** @var \DOMElement $link */
            $downloadUrl = $link->getAttribute('data-downloadurl');
            if ($downloadUrl && isset($documentNames[$documentIndex])) {
                $fileType = pathinfo(parse_url($downloadUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
                
                $documents[] = [
                    'name' => $documentNames[$documentIndex]['title'],
                    'size' => $documentNames[$documentIndex]['size'] ?? 'Tidak diketahui',
                    'downloads' => $documentNames[$documentIndex]['downloads'] ?? '0 downloads',
                    'type' => $fileType,
                    'download' => $downloadUrl,
                    'created_at' => now()->subDays(rand(1, 365)), // Dummy date for sorting
                ];
                $documentIndex++;
            }
        }

        return $documents ?? [];
    }

    /**
     * Clean and normalize document heading
     */
    protected function cleanHeading(string $heading): string
    {
        $cleaned = html_entity_decode(trim($heading), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $cleaned = preg_replace('/[^\x20-\x7E]/', '', $cleaned);
        return trim(str_replace(['â', '�'], '-', $cleaned));
    }

    /**
     * Sort documents based on filter
     */
    protected function sortDocuments(array $documents, string $filter): array
    {
        if ($filter === 'all' || empty($filter)) {
            return $documents;
        }

        usort($documents, function ($a, $b) use ($filter) {
            switch ($filter) {
                case 'name-asc': 
                    return strcmp($a['name'], $b['name']);
                case 'name-desc': 
                    return strcmp($b['name'], $a['name']);
                case 'date-asc': 
                    return strtotime($a['created_at']) - strtotime($b['created_at']);
                case 'date-desc': 
                    return strtotime($b['created_at']) - strtotime($a['created_at']);
                default: 
                    return 0;
            }
        });

        return $documents;
    }
}