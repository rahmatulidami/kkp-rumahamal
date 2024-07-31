<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;

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
                'invoice_id' => $result['id']
            ]]);

            return response()->json([
                'invoice_url' => $result['invoice_url'],
                'invoice_id' => $result['id']
            ]);
        } catch (\Xendit\XenditSdkException $e) {
            return response()->json(['error' => 'Error creating invoice: ' . $e->getMessage()], 400);
        }
    }

    public function webhook(Request $request)
    {
        $payload = $request->all();

        // Verify the webhook signature (implement this based on Xendit's documentation)

        if ($payload['status'] == 'PAID') {
            // Find the donation record and update it
            $donation = Donation::where('invoice_id', $payload['external_id'])->first();
            if ($donation) {
                $donation->status = 'PAID';
                $donation->save();

                // You can broadcast an event here to notify the frontend
                // event(new DonationPaidEvent($donation));
            }
        }

        return response()->json(['success' => true]);
    }

    public function checkStatus($invoiceId)
    {
        // Dalam implementasi sebenarnya, Anda perlu memeriksa status pembayaran di Xendit
        // Untuk sementara, kita akan mensimulasikan pemeriksaan status
        $donationData = session('donation_data');
        if ($donationData && $donationData['invoice_id'] === $invoiceId) {
            // Simulasi pembayaran berhasil setelah beberapa detik
            sleep(5); // Simulasi delay
            return response()->json([
                'status' => 'PAID',
                'name' => $donationData['name'],
                'amount' => $donationData['amount'],
            ]);
        }
        return response()->json(['error' => 'Donation not found'], 404);
    }

}
