<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Donation;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;
use DOMDocument;
use Illuminate\Support\Facades\Log;

class DonationController extends Controller
{
    public function index()
    {
        return view('donation/donate');
    }

    public function show($slug)
    {
        $response = Http::get('https://rumahamal.usk.ac.id/api/wp-json/wp/v2/campaign_unggulan');
        $campaigns = $response->json();

        // Find the campaign with the matching slug
        $campaign = collect($campaigns)->firstWhere('slug', $slug);

        if (!$campaign) {
            abort(404, 'Campaign not found');
        }

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

        $campaign['image'] = $image;

        return view('donation.show', compact('campaign'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'amount' => 'required|numeric|min:1000',
        ]);
    
        $name = $request->input('name') ?: 'Hamba Allah';
    
        $pricing = [
            'QRIS' => ['fee' => 0.007, 'fixed' => false],
            'SHOPEEPAY' => ['fee' => 0.02, 'fixed' => false],
            'DANA' => ['fee' => 0.015, 'fixed' => false],
            'OVO' => ['fee' => 0.02, 'fixed' => false],
            'ALFAMART' => ['fee' => 5000, 'fixed' => true],
            'INDOMARET' => ['fee' => 7000, 'fixed' => true],
            'BSI' => ['fee' => 4000, 'fixed' => true],
            'BNI' => ['fee' => 4000, 'fixed' => true],
            'MANDIRI' => ['fee' => 4000, 'fixed' => true],
        ];
    
        $paymentMethod = $request->input('payment_method');
        $amount = $request->input('amount');
        $feeConfig = $pricing[$paymentMethod];
    
        if ($feeConfig['fixed']) {
            $fee = $feeConfig['fee'];
            $vat = 0.11 * $fee;
            $totalAmount = $amount + $fee + $vat;
        } else {
            $fee = $amount * $feeConfig['fee'];
            $vat = 0.11 * $fee;
            $totalAmount = $amount + $fee + $vat;
        }
    
        Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));
    
        $apiInstance = new InvoiceApi();
        $externalId = 'donation_' . uniqid(); // Generate external_id
        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => $externalId,
            'description' => 'Donation from ' . $name,
            'amount' => $totalAmount,
            'invoice_duration' => 86400, // 1 hari
            'currency' => 'IDR',
            'payer_email' => $request->email,
            'should_send_email' => true,
            'payment_methods' => [$paymentMethod],
            'success_redirect_url' => url('/success'),
            'failure_redirect_url' => url('/failure'),
        ]);
    
        try {
            $result = $apiInstance->createInvoice($create_invoice_request);
    
            // Ambil field yang diperlukan dari $result
            $filteredResult = [
                'transaction_id' => $result['id'],
                'name' => $name,
                'email' => $request->email,
                'payment_method' => $paymentMethod,
                'external_id' => $externalId,
                'campaign_id' => $request->input('campaign_id'),
                'amount' => $amount,
                'status' => 'pending',
                'invoice_id' => $result['id'],
                'invoice_url' => $result['invoice_url'],
                'expiry_date' => $result['expiry_date']->format('Y-m-d H:i:s'), // Format ulang expiry_date
            ];
            $this->sendToWordPress($filteredResult);
    
            return redirect($result['invoice_url']);
        } catch (\Xendit\XenditSdkException $e) {
            return back()->withErrors('Error creating invoice: ' . $e->getMessage());
        }
    }

    private function sendToWordPress($data)
    {
        $wordpressEndpoint = env('WORDPRESS_API_URL') . '/wp-json/myplugin/v1/record-donation';
        $username = env('WORDPRESS_USERNAME'); // Masukkan username ke .env
        $applicationPassword = env('WORDPRESS_APPLICATION_PASSWORD'); // Masukkan Application Password ke .env
    
        $auth = base64_encode($username . ':' . $applicationPassword);
    
        try {
            // dd($data); // Debugging: Tampilkan data yang akan dikirim
            \Log::info('Payload sent to WordPress:', $data); // Log payload yang dikirim
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $auth,
            ])->post($wordpressEndpoint, $data);
    
            if (!$response->successful()) {
                throw new \Exception('Failed to send data to WordPress: ' . $response->body());
            }
        } catch (\Exception $e) {
            // Log error jika pengiriman data gagal
            \Log::error('Error syncing with WordPress: ' . $e->getMessage());
            throw $e;
        }
    }

    public function handleWebhook(Request $request)
    {
        // Xendit verification token
        $xenditToken = env('XENDIT_CALLBACK_TOKEN', 'JxoUZ8AordUsuMt7Fe4nhG2JKPWmjPLeyEKNpviB1jqmmaTq');

        // Retrieve the incoming Xendit callback token from the header
        $incomingToken = $request->header('x-callback-token');

        // Validate the token
        if ($incomingToken !== $xenditToken) {
            Log::warning('Invalid Xendit callback token received.');
            return response()->json(['message' => 'Invalid callback token'], 403);
        }

        // Get payload from the webhook
        $data = $request->all();

        // Log the received payload for debugging
        Log::info('Xendit Webhook received', $data);

        // Forward the payload to WordPress
        $this->forwardToWordPress($data);

        return response()->json(['message' => 'Webhook forwarded to WordPress successfully'], 200);
    }

    /**
     * Forward the Xendit payload to the WordPress endpoint.
     */
    private function forwardToWordPress(array $data)
    {
        // WordPress API endpoint to handle the webhook
        $wordpressApiUrl = env('WORDPRESS_API_URL') . '/wp-json/custom/v1/xendit-callback';

        // WordPress API credentials (if authentication is required)
        $wordpressUsername = env('WORDPRESS_USERNAME');
        $wordpressPassword = env('WORDPRESS_APPLICATION_PASSWORD');

        // Make POST request to WordPress
        $response = Http::withBasicAuth($wordpressUsername, $wordpressPassword)
            ->post($wordpressApiUrl, $data);

        if ($response->failed()) {
            Log::error('Failed to forward webhook to WordPress', [
                'response' => $response->body()
            ]);
            return;
        }

        Log::info('Webhook successfully forwarded to WordPress', [
            'response' => $response->body()
        ]);
    }


    // public function handleXenditCallback(Request $request)
    // {
    //     $data = $request->all();

    //     // Verify the callback is from Xendit
    //     // You can use Xendit's SDK to verify the callback
    //     // For simplicity, let's assume it's a valid callback

    //     if (isset($data['status']) && $data['status'] == 'PAID') {
    //         $donationData = session('donation_data');

    //         if ($donationData && $donationData['invoice_id'] == $data['id']) {
    //             // Save donation to the database
    //             $donation = new Donation();
    //             $donation->name = $donationData['name'];
    //             $donation->email = $donationData['email'];
    //             $donation->amount = $donationData['amount']; // Save the original amount
    //             $donation->payment_method = $donationData['payment_method'];
    //             $donation->invoice_id = $donationData['invoice_id']; // Save the Xendit invoice ID for reference
    //             $donation->save();

    //             // Clear session data
    //             session()->forget('donation_data');
    //         }
    //     }

    //     return response()->json(['message' => 'Callback received']);
    // }

}
