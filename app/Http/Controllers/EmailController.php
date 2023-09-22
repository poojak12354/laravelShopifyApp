<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Http\Requests;

class EmailController extends Controller
{
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

    // public function send(Request $request){
    //     $subject = $request->get('subject');
    //     $mesg_body = $request->get('message');
    //     $email = $request->get('mail');
    //     $info = array(
    //         'message' => urldecode($mesg_body),
    //         'subject' => $subject,
    //         'type' => 'quotation'
    //     );
        
    //     Mail::to($email)->send(new \App\Mail\SendQuotationEmail($info));
    //     return json_encode(array('status'=>'success', 'message' => 'Mail sent successfully!'));
    // }
}
