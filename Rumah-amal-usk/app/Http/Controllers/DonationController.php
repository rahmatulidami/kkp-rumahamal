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

        $donation = new Donation();
        $donation->name = $name;
        $donation->email = $request->email;
        $donation->amount = $request->amount;
        $donation->payment_method = $request->payment_method;
        $donation->save();

        Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));

        $apiInstance = new InvoiceApi();
        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => 'donation_' . $donation->id,
            'description' => 'Donation from ' . $donation->name,
            'amount' => $donation->amount,
            'invoice_duration' => 86400, // 1 hari
            'currency' => 'IDR',
            'payer_email' => $donation->email,
            'should_send_email' => true,
            'payment_methods' => [$donation->payment_method],
            'success_redirect_url' => url('/success'),
            'failure_redirect_url' => url('/failure'),
        ]);

        try {
            $result = $apiInstance->createInvoice($create_invoice_request);
            return redirect($result['invoice_url']);
        } catch (\Xendit\XenditSdkException $e) {
            return back()->withErrors('Error creating invoice: ' . $e->getMessage());
        }
    }
}
