<?php

namespace App\Http\Controllers;

use App\Utility\MomoApi;
use Illuminate\Http\Request;
use Bhekor\LaravelFlutterwave\Facades\Flutterwave;
use Exception;
use Bmatovu\MtnMomo\Products\Collection;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe;
class PaymentController extends Controller
{
    //
    // Flutterwave Payment
    public function initFlutter($details){
        // dd($details);
        $reference = getTrx(15);
        $details['reference'] = $reference;
        // Enter the details of the payment
        $data = [
            // 'payment_options' => 'card,banktransfer',
            'amount' => $details['amount'],
            'email' => $details['email'],
            'tx_ref' => $reference,
            'currency' => get_setting('currency_code') ?? "NGN",
            'redirect_url' => route('flutter.success'),
            'customer' => [
                'email' => $details['email'],
                "phone_number" => $details['phone'],
            ],
            'meta' => $details
        ];

        // return $data;
        $payment = Flutterwave::initializePayment($data);

        if ($payment['status'] !== 'success') {
            // notify something went wrong
            return back()->withError('Payment Not Successful');
        }

        return redirect($payment['data']['link']);
	}
    public function flutter_success(Request $request)
    {
        $status = request()->status;
        $details = $request->session()->get('payment_data');

        //if payment is successful
        if ($status ==  'successful' || $status == 'completed') {
            $transactionID = Flutterwave::getTransactionIDFromCallback();
            $payment = Flutterwave::verifyTransaction($transactionID);
            $details = $payment['data']['meta'];
            $paydone = new HomeController;
            return $paydone->complete_voting($details, $payment);
        }
        elseif ($status ==  'cancelled'){
            return redirect()->route('index')->withError('Payment was not Successful. Please try again');
        }
        else{
            return redirect()->route('index')->withError('Payment was not Successful. Please try again');
        }

	}

    // Paypal Payment
    function initPaypal($details){
        // return $details;
        $reference = getTrx(15);
        $details['reference'] = $reference;
        // put $details to session
        session()->put('payment_data', $details);

        $provider = \PayPal::setProvider();
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.success'),
                "cancel_url" => route('paypal.cancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => get_setting('currency_code2'),
                        "value" => $details['amount2']
                    ]
                ]
            ]
        ]);
        if (isset($response['id']) && $response['id'] != null) {
            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()
                ->route('index')
                ->with('error', 'Something went wrong.');
        } else {
            return redirect()
                ->route('index')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }

    }
    public function paypal_cancel(Request $request)
    {
        return redirect()
            ->route('index')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }
    function paypal_success(Request $request){

        $details = $request->session()->get('payment_data');

        $provider = \PayPal::setProvider();
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $paydone = new HomeController;
            return $paydone->complete_voting($details, $response);

        } else {
            return redirect()
                ->route('index')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    // Stripe Payment
    function initStripe($details){
        $reference = getTrx(15);
        $details['reference'] = $reference;
        // put $details to session
        session()->put('payment_data', $details);
        return view('stripe', compact('details'));
    }
    function stripe_payment(Request $request){
        $details = $request->session()->get('payment_data');
        try{

            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            // dd($request);
            // return $details;
            $amount = number_format($details['amount2']);
            $payment = json_encode(Stripe\Charge::create ([
                "amount" => round($amount * 100 , 2),
                "currency" => get_setting('currency_code2'),
                "source" => $request->stripeToken,
                "description" => $details['desc']
            ]));
            $paydone = new HomeController;
            return $paydone->complete_voting($details, $payment);
        }catch(Exception $e){
            // return $e;
            return redirect()
                ->route('index')
                ->with('error', $e->getMessage() ?? 'Something went wrong.');
        }

    }

    // Momo Payment
    function initMomo($details){
        $reference = getTrx(15);
        $details['reference'] = $reference;
        $amount = $details['amount2'];
        session()->put('payment_data', $details);
        try{
            $collection = new MomoApi();
            // return $collection->getToken();
            $transactionId = $collection->requestToPay($reference, $details['phone'], 10, $details['desc']);

            $response = $collection->getTransactionStatus($transactionId);
            if ($response['status'] == "SUCCESSFUL") {
                // code...
                $paydone = new HomeController;
                return $paydone->complete_voting($details, $response);
            } else {
                // code...
                return redirect()
                    ->route('index')
                    ->with('error', $response['message'] ?? 'Payment was not successful. Something went wrong.');
            }
        }catch(Exception $e){
            // dd($e);
            return redirect()
                ->route('index')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }
}
