<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Donation;
use DOMDocument;

class CampaignController extends Controller
{
    public function index()
    {
        // Fetch data from the API
        $response = Http::get('https://rumahamal.usk.ac.id/api/wp-json/wp/v2/campaign_unggulan');
        $campaigns = $response->json();

        // Process campaigns to extract image URLs
        $processedCampaigns = array_map(function ($campaign) {
            $terkumpul = $campaign['acf']['dana_terkumpul'] ?? 0;
            $dibutuhkan = $campaign['acf']['jumlah_dana'] ?? 1; // Avoid division by zero
            $percentage = ($dibutuhkan > 0) ? ($terkumpul / $dibutuhkan) * 100 : 0;
            $category = strtolower($campaign['type'] ?? 'uncategorized');

            // Extract image URL from content.rendered
            $doc = new DOMDocument();
            libxml_use_internal_errors(true);
            $doc->loadHTML($campaign['content']['rendered']);
            libxml_clear_errors();
            $imgTags = $doc->getElementsByTagName('img');
            $image = $imgTags->length > 0 ? $imgTags->item(0)->getAttribute('src') : '';

            // Add new fields to the campaign array
            $campaign['terkumpul'] = $terkumpul;
            $campaign['dibutuhkan'] = $dibutuhkan;
            $campaign['percentage'] = $percentage;
            $campaign['category'] = $category;
            $campaign['image'] = $image;

            return $campaign;
        }, $campaigns);

        // Pass processed data to the view
        return view('campaign.campaign', compact('processedCampaigns'));
    }

    public function show($slug)
    {
        // Fetch all campaigns to find the one with the matching slug
        $allCampaignsResponse = Http::get('https://rumahamal.usk.ac.id/api/wp-json/wp/v2/campaign_unggulan');
        $allCampaigns = $allCampaignsResponse->json();
        
        // Find the campaign with the matching slug
        $campaign = collect($allCampaigns)->firstWhere('slug', $slug);

        if (!$campaign) {
            abort(404, 'Campaign not found');
        }

        // Fetch all donors from the database
        $donors = Donation::all();

        // Fetch related campaigns
        $relatedCampaignsResponse = Http::get('https://rumahamal.usk.ac.id/api/wp-json/wp/v2/campaign_unggulan');
        $relatedCampaigns = $relatedCampaignsResponse->json();

        // Remove the current campaign from the related campaigns array
        $relatedCampaigns = array_filter($relatedCampaigns, function($relatedCampaign) use ($slug) {
            return $relatedCampaign['slug'] != $slug;
        });

        // Limit related campaigns to 3
        $relatedCampaigns = array_slice($relatedCampaigns, 0, 3);

        // Process the campaign
        $terkumpul = $campaign['acf']['dana_terkumpul'] ?? 0;
        $dibutuhkan = $campaign['acf']['jumlah_dana'] ?? 1;
        $percentage = ($dibutuhkan > 0) ? ($terkumpul / $dibutuhkan) * 100 : 0;
        $category = strtolower($campaign['type'] ?? 'uncategorized');

        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($campaign['content']['rendered']);
        libxml_clear_errors();

        // Extract image URL from content.rendered
        $imgTags = $doc->getElementsByTagName('img');
        $image = $imgTags->length > 0 ? $imgTags->item(0)->getAttribute('src') : '';

        // Remove all image tags from the content
        $xpath = new \DOMXPath($doc);
        foreach ($xpath->query('//img') as $img) {
            $img->parentNode->removeChild($img);
        }
        $contentWithoutImages = $doc->saveHTML();

        // Add necessary fields to the campaign
        $campaign['terkumpul'] = $terkumpul;
        $campaign['dibutuhkan'] = $dibutuhkan;
        $campaign['percentage'] = $percentage;
        $campaign['category'] = $category;
        $campaign['image'] = $image;
        $campaign['content']['rendered'] = $contentWithoutImages;

        // Pass campaign, donors, and related campaigns data to the view
        return view('campaign.detail-campaign', compact('campaign', 'donors', 'relatedCampaigns'));
    }
}
