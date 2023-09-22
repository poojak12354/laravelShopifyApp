<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quotes;

use Mail;
use Illuminate\Support\Facades\DB;

class QuotesController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index()
    {
        $quotes = DB::table('quotes')->leftJoin('payment_links', 'payment_links.qid', '=', 'quotes.id')->leftJoin('payments', 'payments.qid', '=', 'quotes.id')->select(['quotes.*','payment_links.payment_link','payments.id as paymentId','payments.transaction_id','payments.charge_id','payments.trasaction_status','payments.amount as paid_amt','payments.billing_info','payments.comment_note','payments.reciept_url','payments.straighten as checkout_straighten','payments.resize as checkout_resize'])->orderBy('quotes.id', 'desc')->get();
        
        return view('admin/quotes')->with('quotes', $quotes);
    }
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        header('Access-Control-Allow-Origin: *');
        parse_str($request->getContent(), $data);
        $arrComplex = ['easy'=> '2.50', 'hard'=> '5.00'];
        $services = array();
        if(!empty($data['services'])){
            foreach($data['services'] as $sevice){
                $services[$sevice] = $sevice;
                if($sevice == "resize"){
                    $services['resize_dimensions'] = $data['resize'];
                }
            }
        }
        $amount = $arrComplex[$data['complexity']] * $data['images_count'];
        
        $newQuote = new Quotes([
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'email' => $data['email'],
            'currency' => $data['currency'],
            'image_complexity' => $data['complexity'],
            'services' => json_encode($services),
            'file_type' => $data['file_format'],
            'comment' => $data['comment'],
            'images_count' => $data['images_count'],
            'total_amount' => $amount
        ]);

        $newQuote->save();
        echo $newQuote->id;
        die();
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $quote = Quotes::findOrFail($id);
        return response()->json($quote);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        $quote = Quotes::findOrFail($id);

        $request->validate([
            'fname' => 'required|max:255',
            'lname' => 'required|max:255',
            'email' => 'required|email:filter',
            'currency' => 'required',
            'image_complexity' => 'required',
            'services' => 'required',
            'file_type' => 'required',
            'comment' => 'required',
            'images_count' => 'required',
            'images' => 'required',
            'total_amount' => 'required'
        ]);

        $quote->fname = $request->get('fname');
        $quote->lname = $request->get('lname');
        $quote->email = $request->get('email');
        $quote->currency = $request->get('currency');
        $quote->image_complexity = $request->get('complexity');
        $quote->services = $request->get('services');
        $quote->file_type = $request->get('file_format');
        $quote->comment = $request->get('comment');
        $quote->images_count = $request->get('images_count');
        $quote->images = $request->get('images');
        $quote->total_amount = $request->get('amount');

        $quote->save();

        return response()->json($quote);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        $quote = Quotes::findOrFail($id);
        $quote->delete();

        return response()->json($quote::all());
    }

    /**
    * Send email to the user with quotes
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function send(Request $request){
        $subject = $request->get('subject');
        $mesg_body = $request->get('message');
        $email = $request->get('mail');
        $info = array(
            'message' => urldecode($mesg_body),
            'subject' => $subject,
            'type' => 'quotation'
        );
        
        Mail::to($email)->send(new \App\Mail\SendQuotationEmail($info));
        return json_encode(array('status'=>'success', 'message' => 'Mail sent successfully!'));
    }
}
