<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentLinks;
use Mail;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index($token)
    {
        $explodToken = explode('-',$token);
        $linkId = base64_decode($explodToken[0]);
        $qid = base64_decode($explodToken[1]);
        
        $hasPayment =  DB::table('payments')->select(['*'])->where('qid', $qid)->first();        
        if(!empty($hasPayment)){
            return view('auth/paid')->with('paymentDetails', $hasPayment);
        } else {
            $quotes = DB::table('payment_links')->join('quotes', 'quotes.id', '=', 'payment_links.qid')->select(['quotes.*','payment_links.amount_payable'])->where(['quotes.id' => $qid, 'payment_links.id' => $linkId])->get();
            return view('auth/payment')->with('quoteDetail', $quotes);
        }
        
    }

    public function sendPayLink(Request $request)
    {
        $email = $request->get('mail');
        $qid = $request->get('id');
        $amt = $request->get('amount');
        $paymentLinks = new PaymentLinks([
            'amount_payable' => $amt,
            'qid' => $qid
        ]);

        $paymentLinks->save();
        $insertID = $paymentLinks->id;
        $link = config('app.url').'makepayment/'.base64_encode($insertID).'-'.base64_encode($qid);

        $lastLink = PaymentLinks::findOrFail($insertID);
        $lastLink->payment_link = $link;
        $lastLink->save();

        $qt_image = DB::table('quotes')->where('id', $qid)->first(['images_count','currency']);

        $info = array(
            'link' => $link,
            'subject' => "Your quote #Q".$qid." is ready!",
            'type' => 'paylink',
            'quote_id' => $qid,
            'image_count' => $qt_image->images_count,
            'amount_payable' => $amt,
            'currency' => $qt_image->currency
        );
        
        Mail::to($email)->send(new \App\Mail\SendQuotationEmail($info));

        return json_encode(array('status' => '200', 'link'=> $link, 'message' => 'Payment link sent successfully!'));
    }

    public function thankyou($token){
        $pid = base64_decode($token);
        $quotes = DB::table('payments')->join('quotes', 'quotes.id', '=', 'payments.qid')->select(['payments.*','quotes.fname','quotes.lname','quotes.email','quotes.images_count'])->where(['payments.id' => $pid])->first();
        return view('auth/thankyou')->with('quoteDetail', $quotes);
    }
}
