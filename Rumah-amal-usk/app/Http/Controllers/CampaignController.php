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

            // Extract image URL from content.rendered
            $doc = new DOMDocument();
            libxml_use_internal_errors(true); // Suppress errors due to malformed HTML
            $doc->loadHTML($campaign['content']['rendered']);
            libxml_clear_errors();
            $imgTags = $doc->getElementsByTagName('img');

            // If no image found, use a default image or handle it appropriately
            $image = $imgTags->length > 0 ? $imgTags->item(0)->getAttribute('src') : asset('path/to/default-image.jpg');

            // Add new fields to the campaign array
            $campaign['terkumpul'] = $terkumpul;
            $campaign['dibutuhkan'] = $dibutuhkan;
            $campaign['percentage'] = $percentage;
            $campaign['image'] = $image;

            return $campaign;
        }, $campaigns);

        // Pass processed data to the view
        return view('campaign.campaign', compact('processedCampaigns'));
    }

    public function show($slug)
    {
        // Fetch all campaigns from the API
        $response = Http::get('https://rumahamal.usk.ac.id/api/wp-json/wp/v2/campaign_unggulan');
        $campaigns = $response->json();

        // Find the campaign with the matching slug
        $campaign = collect($campaigns)->firstWhere('slug', $slug);

        if (!$campaign) {
            abort(404, 'Campaign not found');
        }

        // Process the main campaign (the one being viewed)
        $terkumpul = $campaign['acf']['dana_terkumpul'] ?? 0;
        $dibutuhkan = $campaign['acf']['jumlah_dana'] ?? 1;
        $percentage = ($dibutuhkan > 0) ? ($terkumpul / $dibutuhkan) * 100 : 0;

        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($campaign['content']['rendered']);
        libxml_clear_errors();

        // Extract image URL from content.rendered
        $imgTags = $doc->getElementsByTagName('img');
        $image = $imgTags->length > 0 ? $imgTags->item(0)->getAttribute('src') : asset('path/to/default-image.jpg');

        // Remove all image tags from the content
        $xpath = new \DOMXPath($doc);
        foreach ($xpath->query('//img') as $img) {
            $img->parentNode->removeChild($img);
        }
        $contentWithoutImages = $doc->saveHTML();

        // Add necessary fields to the main campaign
        $campaign['terkumpul'] = $terkumpul;
        $campaign['dibutuhkan'] = $dibutuhkan;
        $campaign['percentage'] = $percentage;
        $campaign['image'] = $image;
        $campaign['content']['rendered'] = $contentWithoutImages;

        // Fetch all donors from the database
        $donors = Donation::all();

        // Filter out campaigns that are exactly the same
        $otherCampaigns = collect($campaigns)
            ->filter(function ($otherCampaign) use ($campaign) {
                return $otherCampaign['slug'] !== $campaign['slug']; // Exclude current campaign based on slug
            })
            ->shuffle() // Randomize the remaining campaigns
            ->take(3)   // Take only 3 distinct campaigns
            ->values(); // Reset keys after filtering

        // Process each other campaign
        $otherCampaigns = $otherCampaigns->map(function ($otherCampaign) {
            $terkumpul = $otherCampaign['acf']['dana_terkumpul'] ?? 0;
            $dibutuhkan = $otherCampaign['acf']['jumlah_dana'] ?? 1;
            $percentage = ($dibutuhkan > 0) ? ($terkumpul / $dibutuhkan) * 100 : 0;

            $doc = new DOMDocument();
            libxml_use_internal_errors(true);
            $doc->loadHTML($otherCampaign['content']['rendered']);
            libxml_clear_errors();

            // Extract image URL from content.rendered
            $imgTags = $doc->getElementsByTagName('img');
            $image = $imgTags->length > 0 ? $imgTags->item(0)->getAttribute('src') : asset('path/to/default-image.jpg');

            // Add necessary fields to the other campaign
            $otherCampaign['terkumpul'] = $terkumpul;
            $otherCampaign['dibutuhkan'] = $dibutuhkan;
            $otherCampaign['percentage'] = $percentage;
            $otherCampaign['image'] = $image;

            return $otherCampaign;
        });

        // Pass campaign, donors, and 3 distinct other campaigns to the view
        return view('campaign.detail-campaign', compact('campaign', 'donors', 'otherCampaigns'));
    }
}
