<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contestant;
use App\Models\Payment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::whereStatus(1)->get();
        return view('home', compact('categories'));
    }

    function view_category($slug){
        $category = Category::whereSlug($slug)->first();
        if($category == null){
            return redirect()->route('index')->withError('Category Not Found');
        }
        return view('category', compact('category'));
    }

    function vote_modal(Request $request){
        $contestant = Contestant::findOrFail($request->id);
        return view('vote-modal', compact('contestant'));

    }
    function vote_contestant(Request $request){
        $contestant = Contestant::findOrFail($request->contestant_id);
        $price = get_setting('price');
        $amount = $request->quantity * $price;
        $amount2 = $request->quantity * get_setting('price2');
        $details = $request->all();
        $details['amount'] = $amount;
        $details['amount2'] = $amount2;
        // $details['amount2'] = number_format($amount / get_setting('currency_rate'), 3);  //convert to EUR
        $details['desc'] = "Payment for {$contestant->name}";
        // return $details;
        $payment = new PaymentController;
        if($request->payment_type == 'momo'){
            // dd($details);
            $request->session()->put('payment_data', $details);
            return $payment->initMomo($details);
        }
        if($request->payment_type == 'flutterwave'){
            $request->session()->put('payment_data', $details);
            return $payment->initFlutter($details);
        }
        if($request->payment_type == 'stripe'){
            $details['amount'] = $amount2;
            if($details['amount2'] < 1){
                return back()->withError('Amount is Less than 1');
            }
            $request->session()->put('payment_data', $details);
            return $payment->initStripe($details);
        }
        if($request->payment_type == 'paypal'){
            $details['amount'] = $amount2;
            if($details['amount2'] < 1){
                return back()->withError('Amount is Less than 1');
            }
            $request->session()->put('payment_data', $details);
            return $payment->initPaypal($details);
        }

        return back()->withError('Something Went Wrong. Please Try Again');


    }

    function complete_voting($details, $paydata){
        $contestant = Contestant::findOrFail($details['contestant_id']);
        // Check if trx doesnt exist
        $checkTrx = Payment::whereCode($details['reference'])->first();
        if($checkTrx) return redirect()->route('index')->withError('Payment already Completed. Please try again');
        $contestant->votes += $details['quantity'];
        $contestant->save();
        // Add to payment History
        $payments = new Payment();
        $payments->contestant_id = $details['contestant_id'];
        $payments->payment_method = $details['payment_type'];
        $payments->name = "Awesome Voter";
        $payments->country = $details['country'] ?? "";
        $payments->phone = $details['phone'];
        $payments->code = $details['reference'] ?? getTrx(15);
        $payments->votes = $details['quantity'];
        $payments->payment_details = $details['desc'];
        $payments->email = $details['email'];
        $payments->amount = $details['amount'];
        $payments->status = 1;
        $payments->response = json_encode($paydata);
        $payments->save();

        // Send Email ??
        $msg = "Your vote has been taken into account. {$details['desc']}. Thanks for Sharing ";
        return redirect()->route('index')->withSuccess($msg)->withVsuccess($msg);
    }
    function logout(){
        auth()->logout();
        return redirect('/');
    }
}
