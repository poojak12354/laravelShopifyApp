<?php
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use Session;
use Stripe;
use App\Models\Payments;
use Mail;

class StripePaymentController extends Controller
{
   
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        try {
            $formData = $request->all();
            $formFields=  array();
            parse_str($formData['frmd'], $formFields);
            
            $token = $request->get('key');
            $amt = $formFields['amt'];
            $cur = $formFields['cur'];
            $uemail = $formFields['uemail'];
            unset($formFields['amt']);
            unset($formFields['cur']);
            
            $paymentData = new Payments([
                'qid' => $formFields['qid'],
                'amount' => $amt,
                'currency' => $cur,
                'billing_info' => json_encode($formFields),
                'comment_note' => urldecode($request->get('comment')),
                'straighten' => $request->get('straighten'),
                'resize' => $request->get('resize')
            ]);
    
            $paymentData->save();
            $paymentId = $paymentData->id;

            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $ischarged = Stripe\Charge::create ([
                "amount" => $amt*100,
                "currency" => $cur,
                "source" => $token,
                "description" => "Bigturntable images customize payment",
                "receipt_email" => $uemail,
                "metadata" => $formFields
            ]);

            $lastPayment = Payments::findOrFail($paymentId);
            if(isset($ischarged) && $ischarged->captured && $ischarged->status == "succeeded"){
                $lastPayment->reciept_url = $ischarged->receipt_url;
                $lastPayment->charge_id = $ischarged->id;
                $lastPayment->transaction_id = $ischarged->balance_transaction;
                $lastPayment->trasaction_status = 'complete';
                $response = array('status' => '200', 'message' => 'Payment completed.','thankyou' => url('/thank-you/'.base64_encode($paymentId)));
                
                // code to send emails
                $infoUser = array(
                    'link' => $ischarged->receipt_url,
                    'subject' => "Payment Completed",
                    'paymentinfo' => $lastPayment,
                    'type' => 'complete'
                );
                
                Mail::to($uemail)->send(new \App\Mail\SendQuotationEmail($infoUser));

                $infoAdmin = array(
                    'link' => $ischarged->receipt_url,
                    'subject' => "A new payment recieved for quote #Q".$formFields['qid'],
                    'type' => 'order'
                );
                
                Mail::to(env('ADMIN_EMAIL'))->send(new \App\Mail\SendQuotationEmail($infoAdmin));
            } else {               
                $lastPayment->trasaction_status = 'failed';
                $response = array('status' => '202', 'message' => $ischarged->failure_message);
            }
            $lastPayment->save();

        } catch (\Stripe\Error\Base $e) {
            $response = array('status' => '204', 'message' => $e->getMessage());
        } catch (Exception $e) {
            $response = array('status' => '204', 'message' => $e->getMessage());
        }
        echo json_encode($response);
    }
}