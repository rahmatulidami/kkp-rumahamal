<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Donation;
use Xendit\Configuration;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\InvoiceItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class DonationController extends Controller
{
    public function index()
    {
        return view('donation/donate');
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
        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => 'donation_' . uniqid(),
            'description' => 'Donation from ' . $name,
            'amount' => $totalAmount,
            'invoice_duration' => 86400, // 1 hari
            'currency' => 'IDR',
            'payer_email' => $request->email,
            'should_send_email' => true,
            'payment_methods' => [$paymentMethod],
        ]);

        try {
            $result = $apiInstance->createInvoice($create_invoice_request);

            session(['donation_data' => [
                'name' => $name,
                'email' => $request->email,
                'amount' => $amount,
                'payment_method' => $paymentMethod,
                'invoice_id' => $result['id'],
                'campaign_name' => $request->input('campaign_name'),
                'campaign_id' => $request->input('campaign_id')
            ]]);
            \Log::info('Session data:', session('donation_data'));

            return response()->json([
                'invoice_url' => $result['invoice_url'],
                'invoice_id' => $result['id']
            ]);
        } catch (\Xendit\XenditSdkException $e) {
            return response()->json(['error' => 'Error creating invoice: ' . $e->getMessage()], 400);
        }
    }

    public function notificationCallback(Request $request)
    {
        $sessionData = session('donation_data', []);
        \Log::info('Session data in callback:', $sessionData);
        // Mendapatkan token xendit dari header
        $xenditToken = $request->header('x-callback-token');
        $callbackToken = env('XENDIT_CALLBACK_TOKEN');

        // Verifikasi token
        if ($xenditToken !== $callbackToken) {
            return response()->json(['error' => 'Invalid callback token'], 401);
        }

        // Mendapatkan payload
        $payload = $request->all();

        // Memeriksa apakah status pembayaran adalah PAID
        if ($payload['status'] === 'PAID') {
            try {

                $sessionData = session('donation_data', []);

                // Menyimpan data ke database
                $donation = new Donation();
                $donation->payment_id = $payload['id'];
                $donation->campaign_name = $sessionData['campaign_name'] ?? 'General Donation';
                $donation->name = $sessionData['name'] ?? 'Hamba Allah';
                $donation->email = $sessionData['email'] ?? $payload['payer_email'];
                $donation->amount = $payload['amount'];
                $donation->payment_method = $payload['payment_method'];
                $donation->status = 'paid';
                $donation->save();

                if (isset($sessionData['campaign_id'])) {
                    $this->updateCampaignDanaTerkumpul($sessionData['campaign_id'], $payload['amount']);
                }
                // Anda bisa menambahkan logika tambahan di sini, seperti mengirim email terima kasih

                return response()->json([
                    'status' => 'success',
                    'message' => 'Payment processed and saved successfully'
                ], 200);
            } catch (\Exception $e) {
                // Jika terjadi kesalahan saat menyimpan ke database
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error saving payment data: ' . $e->getMessage()
                ], 500);
            }
        }

        // Menangani status lain jika diperlukan
        return response()->json(['message' => 'Notification received'], 200);
    }

    private function updateCampaignDanaTerkumpul($campaignId, $amount)
    {
        $username = env('WP_API_USERNAME');
        $password = env('WP_API_PASSWORD');

        // Fetch current campaign data
        $response = Http::withBasicAuth($username, $password)
            ->get("https://rumahamal.usk.ac.id/wp-json/wp/v2/campaign_unggulan/{$campaignId}");

        if ($response->successful()) {
            $campaign = $response->json();
            $currentDanaTerkumpul = $campaign['acf']['dana_terkumpul'] ?? 0;
            $newDanaTerkumpul = $currentDanaTerkumpul + $amount;

            // Update dana_terkumpul
            $updateResponse = Http::withBasicAuth($username, $password)
                ->post("https://rumahamal.usk.ac.id/wp-json/wp/v2/campaign_unggulan/{$campaignId}", [
                    'acf' => [
                        'dana_terkumpul' => $newDanaTerkumpul
                    ]
                ]);

            if ($updateResponse->successful()) {
                \Log::info("Dana terkumpul updated successfully for campaign {$campaignId}. New value: {$newDanaTerkumpul}");
            } else {
                \Log::error("Failed to update dana terkumpul for campaign {$campaignId}: " . $updateResponse->body());
            }
        } else {
            \Log::error("Failed to fetch campaign data for ID {$campaignId}: " . $response->body());
        }
    }


}
