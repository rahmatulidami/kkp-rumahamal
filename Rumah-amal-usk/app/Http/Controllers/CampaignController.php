<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DOMDocument;

class CampaignController extends Controller
{
    public function index()
    {
        // Fetch data from the API
        $response = Http::get('https://rumahamal.usk.ac.id/wp-json/wp/v2/campaign_unggulan');
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

    public function show($id)
    {
        // Fetch data for a single campaign by ID
        $response = Http::get('https://rumahamal.usk.ac.id/wp-json/wp/v2/campaign_unggulan/' . $id);
        $campaign = $response->json();

        if (!$campaign) {
            abort(404, 'Campaign not found');
        }

        // Fetch donors data
        $donorsResponse = Http::get('https://rumahamal.usk.ac.id/wp-json/wp/v2/campaign_donors?campaign_id=' . $id);
        $donors = $donorsResponse->json();

        // Fetch related campaigns
        $relatedCampaignsResponse = Http::get('https://rumahamal.usk.ac.id/wp-json/wp/v2/campaign_unggulan');
        $relatedCampaigns = $relatedCampaignsResponse->json();

        // Remove the current campaign from the related campaigns array
        $relatedCampaigns = array_filter($relatedCampaigns, function($relatedCampaign) use ($id) {
            return $relatedCampaign['id'] != $id;
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

        // Ensure donors key exists and is an array
        $campaign['terkumpul'] = $terkumpul;
        $campaign['dibutuhkan'] = $dibutuhkan;
        $campaign['percentage'] = $percentage;
        $campaign['category'] = $category;
        $campaign['image'] = $image;
        $campaign['donors'] = is_array($donors) ? $donors : [];
        $campaign['content']['rendered'] = $contentWithoutImages;

        // Ensure each related campaign has a category key
        foreach ($relatedCampaigns as &$relatedCampaign) {
            $relatedCampaign['category'] = strtolower($relatedCampaign['type'] ?? 'uncategorized');
        }

        // Pass campaign, donors, and related campaigns data to the view
        return view('campaign.detail-campaign', compact('campaign', 'relatedCampaigns'));
    }

    public function donate($id)
    {
        // Fetch data for a single campaign by ID
        $response = Http::get('https://rumahamal.usk.ac.id/wp-json/wp/v2/campaign_unggulan/' . $id);
        $campaign = $response->json();

        if (!$campaign) {
            abort(404, 'Campaign not found');
        }

        // Fetch donors data
        $donorsResponse = Http::get('https://rumahamal.usk.ac.id/wp-json/wp/v2/campaign_donors?campaign_id=' . $id);
        $donors = $donorsResponse->json();

        // Fetch related campaigns
        $relatedCampaignsResponse = Http::get('https://rumahamal.usk.ac.id/wp-json/wp/v2/campaign_unggulan');
        $relatedCampaigns = $relatedCampaignsResponse->json();

        // Remove the current campaign from the related campaigns array
        $relatedCampaigns = array_filter($relatedCampaigns, function($relatedCampaign) use ($id) {
            return $relatedCampaign['id'] != $id;
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

        // Ensure donors key exists and is an array
        $campaign['terkumpul'] = $terkumpul;
        $campaign['dibutuhkan'] = $dibutuhkan;
        $campaign['percentage'] = $percentage;
        $campaign['category'] = $category;
        $campaign['image'] = $image;
        $campaign['donors'] = is_array($donors) ? $donors : [];
        $campaign['content']['rendered'] = $contentWithoutImages;

        // Ensure each related campaign has a category key
        foreach ($relatedCampaigns as &$relatedCampaign) {
            $relatedCampaign['category'] = strtolower($relatedCampaign['type'] ?? 'uncategorized');
        }

        // Pass campaign, donors, and related campaigns data to the view
        return view('campaign.donateCampaign', compact('campaign', 'relatedCampaigns'));
    }

    public function updateDanaTerkumpul($campaignId, $amount)
    {
        $response = Http::get('https://rumahamal.usk.ac.id/wp-json/wp/v2/campaign_unggulan/' . $campaignId);
        $campaign = $response->json();

        if (!$campaign) {
            return false;
        }

        $currentDanaTerkumpul = $campaign['acf']['dana_terkumpul'] ?? 0;
        $newDanaTerkumpul = $currentDanaTerkumpul + $amount;

        $token = $this->getJWTToken();

        if (!$token) {
            \Log::error('Failed to get JWT token for updating dana terkumpul');
            return false;
        }

        $updateResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json'
        ])->post('https://rumahamal.usk.ac.id/wp-json/wp/v2/campaign_unggulan/' . $campaignId, [
            'acf' => [
                'dana_terkumpul' => $newDanaTerkumpul
            ]
        ]);

        if ($updateResponse->successful()) {
            \Log::info("Dana terkumpul updated successfully for campaign $campaignId. New total: $newDanaTerkumpul");
            return true;
        } else {
            \Log::error("Failed to update dana terkumpul for campaign $campaignId. Response: " . $updateResponse->body());
            return false;
        }
    }

    private function getJWTToken()
    {
        $response = Http::post('https://rumahamal.usk.ac.id/wp-json/jwt-auth/v1/token', [
            'username' => env('WP_USERNAME'),
            'password' => env('WP_PASSWORD')
        ]);

        if ($response->successful()) {
            return $response->json()['token'];
        }

        \Log::error('Failed to get JWT token. Response: ' . $response->body());
        return null;
    }


}
