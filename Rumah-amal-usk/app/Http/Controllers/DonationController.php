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
            'success_redirect_url' => url('/success'),
            'failure_redirect_url' => url('/failure'),
        ]);

        try {
            $result = $apiInstance->createInvoice($create_invoice_request);

            // Create a temporary record in session
            session(['donation_data' => [
                'name' => $name,
                'email' => $request->email,
                'amount' => $amount, // Store the original amount
                'payment_method' => $paymentMethod,
                'invoice_id' => $result['id'] // Store the Xendit invoice ID for reference
            ]]);

            return redirect($result['invoice_url']);
        } catch (\Xendit\XenditSdkException $e) {
            return back()->withErrors('Error creating invoice: ' . $e->getMessage());
        }
    }

    public function handleXenditCallback(Request $request)
    {
        $data = $request->all();

        // Verify the callback is from Xendit
        // You can use Xendit's SDK to verify the callback
        // For simplicity, let's assume it's a valid callback

        if (isset($data['status']) && $data['status'] == 'PAID') {
            $donationData = session('donation_data');

            if ($donationData && $donationData['invoice_id'] == $data['id']) {
                // Save donation to the database
                $donation = new Donation();
                $donation->name = $donationData['name'];
                $donation->email = $donationData['email'];
                $donation->amount = $donationData['amount']; // Save the original amount
                $donation->payment_method = $donationData['payment_method'];
                $donation->invoice_id = $donationData['invoice_id']; // Save the Xendit invoice ID for reference
                $donation->save();

                // Clear session data
                session()->forget('donation_data');
            }
        }

        return response()->json(['message' => 'Callback received']);
    }
}
