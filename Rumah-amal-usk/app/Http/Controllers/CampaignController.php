<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Donation;
use DOMDocument;

class CampaignController extends Controller
{
    // Cache duration in minutes
    const CACHE_DURATION = 30; 
    
    public function index(Request $request)
    {
        // Use cache for the API response
        $campaigns = Cache::remember('campaigns_data', self::CACHE_DURATION, function () {
            $response = Http::get('https://rumahamal.usk.ac.id/api/wp-json/wp/v2/campaign_unggulan');
            return $response->json();
        });

        // Ambil input pencarian dari query string
        $search = $request->query('search');

        // Filter berdasarkan judul jika ada input pencarian
        if ($search) {
            $campaigns = array_filter($campaigns, function ($campaign) use ($search) {
                return stripos($campaign['title']['rendered'], $search) !== false;
            });
        }

        // Process campaigns to extract image URLs
        $processedCampaigns = array_map(function ($campaign) {
            $terkumpul = $campaign['acf']['dana_terkumpul'] ?? 0;
            $dibutuhkan = $campaign['acf']['jumlah_dana'] ?? 1; 
            $percentage = ($dibutuhkan > 0) ? ($terkumpul / $dibutuhkan) * 100 : 0;

            // Extract image URL from content.rendered
            $doc = new DOMDocument();
            libxml_use_internal_errors(true);
            $doc->loadHTML($campaign['content']['rendered']);
            libxml_clear_errors();
            $imgTags = $doc->getElementsByTagName('img');
            $image = $imgTags->length > 0 ? $imgTags->item(0)->getAttribute('src') : asset('path/to/default-image.jpg');


            $campaign['terkumpul'] = $terkumpul;
            $campaign['dibutuhkan'] = $dibutuhkan;
            $campaign['percentage'] = $percentage;
            $campaign['image'] = $image;

            return $campaign;
        }, $campaigns);

        return view('campaign.campaign', compact('processedCampaigns'));
    }

    public function show($slug)
    {
       
        $campaigns = Cache::remember('campaigns_data', self::CACHE_DURATION, function () {
            $response = Http::get('https://rumahamal.usk.ac.id/api/wp-json/wp/v2/campaign_unggulan');
            return $response->json();
        });

        $campaign = collect($campaigns)->firstWhere('slug', $slug);

        if (!$campaign) {
            abort(404, 'Campaign not found');
        }

        $terkumpul = $campaign['acf']['dana_terkumpul'] ?? 0;
        $dibutuhkan = $campaign['acf']['jumlah_dana'] ?? 1;
        $percentage = ($dibutuhkan > 0) ? ($terkumpul / $dibutuhkan) * 100 : 0;

        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($campaign['content']['rendered']);
        libxml_clear_errors();

        $imgTags = $doc->getElementsByTagName('img');
        $image = $imgTags->length > 0 ? $imgTags->item(0)->getAttribute('src') : asset('path/to/default-image.jpg');

        $xpath = new \DOMXPath($doc);
        foreach ($xpath->query('//img') as $img) {
            $img->parentNode->removeChild($img);
        }
        $contentWithoutImages = $doc->saveHTML();

        $campaign['terkumpul'] = $terkumpul;
        $campaign['dibutuhkan'] = $dibutuhkan;
        $campaign['percentage'] = $percentage;
        $campaign['image'] = $image;
        $campaign['content']['rendered'] = $contentWithoutImages;

        $otherCampaigns = collect($campaigns)
            ->filter(function ($otherCampaign) use ($campaign) {
                return $otherCampaign['slug'] !== $campaign['slug']; 
            })
            ->shuffle() 
            ->take(3)  
            ->values(); 
        $otherCampaigns = $otherCampaigns->map(function ($otherCampaign) {
            $terkumpul = $otherCampaign['acf']['dana_terkumpul'] ?? 0;
            $dibutuhkan = $otherCampaign['acf']['jumlah_dana'] ?? 1;
            $percentage = ($dibutuhkan > 0) ? ($terkumpul / $dibutuhkan) * 100 : 0;

            $doc = new DOMDocument();
            libxml_use_internal_errors(true);
            $doc->loadHTML($otherCampaign['content']['rendered']);
            libxml_clear_errors();

            $imgTags = $doc->getElementsByTagName('img');
            $image = $imgTags->length > 0 ? $imgTags->item(0)->getAttribute('src') : asset('path/to/default-image.jpg');

            $otherCampaign['terkumpul'] = $terkumpul;
            $otherCampaign['dibutuhkan'] = $dibutuhkan;
            $otherCampaign['percentage'] = $percentage;
            $otherCampaign['image'] = $image;

            return $otherCampaign;
        });

        return view('campaign.detail-campaign', compact('campaign', 'otherCampaigns'));
    }
}