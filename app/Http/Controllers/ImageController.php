<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use File;
use Mail;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{
    /**
    * API call to display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function show($qid){
        header('Access-Control-Allow-Origin: *');
        $str_arr = explode('_',$qid);
        $email = base64_decode($str_arr[0]);
        $qouteID = base64_decode($str_arr[1]);
        $mediaImages = Media::where('type','upload')->where('quote_id',$qouteID)->get();
        $html = "";
        if(count($mediaImages) > 0){
            foreach($mediaImages as $media){
                $html .= '<div class="lc-img-container d-inline-flex mr-2">
                <a class="download_file" target="_blank" href="javascript:void(0)" data-token="'.base64_encode($media->quote_id."/".$media->url).'" download data-name="'.$media->url.'"><i class="fa fa-download"></i></a>
                <img src="'.url("images/".$media->quote_id."/".$media->url).'" class="thumb-lg img-thumbnail mt-3" title="'.$media->url.'" data-type="image"/>
            </div>';
            }
        } else {
            $html .= '<div class="no-img">No media found!</div>';
        }
        
        echo json_encode(array('data' => $html));
        die;
    }

    public function downloadImg($file_path){
        $file_path = base64_decode($file_path);
        $filename = explode('/',$file_path);
        $file_path = public_path('images/'.$file_path);
        header('Access-Control-Allow-Origin: *');
        header('Content-Description: File Transfer');
        header('Content-Type: application/force-download');
        header("Content-Disposition: attachment; filename=\"" . basename($filename[1]) . "\";");
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        ob_clean();
        flush();
        readfile($file_path); //showing the path to the server where the file is to be download
        exit;
    }

    /**
    * API call to display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function getUpdatedImages($requestEmail){
        header('Access-Control-Allow-Origin: *');
        $email = base64_decode($requestEmail);
        $quotes = DB::table('quotes')->leftJoin('payments', 'payments.qid', '=', 'quotes.id')->select(['quotes.*',DB::raw('(select count(*) from media as m where m.type = "upload" and m.quote_id=quotes.id) as clientMedia'),'payments.id as paymentId','payments.transaction_id','payments.charge_id','payments.trasaction_status','payments.amount as paid_amt','payments.billing_info','payments.comment_note','payments.reciept_url','payments.straighten as checkout_straighten','payments.resize as checkout_resize'])->where('quotes.email', $email)->orderBy('quotes.id', 'desc')->get();
        $html = '';
        if(!empty($quotes)){
            foreach($quotes as $quote){
                $payment = !empty($quote->paid_amt) ? $quote->paid_amt : $quote->total_amount;
                switch($quote->trasaction_status){
                    case 'complete':
                        $status = 'Completed';
                    break;
                    case 'failed':
                        $status = 'Failed';
                    break;
                    default:
                        $status = 'Unpaid';
                    break;
                }
                $button = '';
                if($quote->clientMedia > 0){
                    $token = $requestEmail.'_'.base64_encode($quote->id);
                    $button .= '<button type="button" title="Download" class="btn btn-download" data-token="'.$token.'"><i class="fa fa-download"></i></button>';
                }
                if(isset($quote->trasaction_status) && $quote->trasaction_status != 'unpaid'){
                    $billingInfo = json_decode($quote->billing_info);
                    $button .= '<button type="button" title="View Payment Info" class="btn btn-paymentInfo"><i class="fa fa-usd"></i></button>';
                    $button .= '<div class="d-none" id="tbl_datapayment">
                        <h3>Invoice Number: # '.$quote->paymentId.' <a href="'.$quote->reciept_url.'" class="btn btn-inverse-dark" target="_blank"><i class="mdi mdi-eye"></i> View Reciept</a></h3>
                        <table class="table table-striped table-striped2">
                            <tr>
                                <td>Total Amount: </td>
                                <td>'.$quote->paid_amt.' '.$quote->currency.'</td>
                            </tr>';
                            if($quote->trasaction_status == 'complete'){
                                $button .= '<tr>
                                    <td>Transaction Id: </td>
                                    <td>'.$quote->transaction_id.'</td>
                                </tr>
                                <tr>
                                    <td>Charge Id: </td>
                                    <td>'.$quote->charge_id.'</td>
                                </tr>';
                            }
                            $button .= '<tr>
                                <td>Status: </td>
                                <td>'.$quote->trasaction_status.'</td>
                            </tr>
                            <tr>
                                <td>Note: </td>
                                <td>'.$quote->comment_note.'</td>
                            </tr>
                            <tr>
                                <td>Straighten : </td>
                                <td>'.($quote->checkout_straighten ? 'Yes' : 'No').'</td>
                            </tr>
                            <tr>
                                <td>Resize : </td>
                                <td>'.$quote->checkout_resize.'</td>
                            </tr>
                            <tr>
                                <td>Billing Info: </td>
                                <td>'.(isset($billingInfo->fname) ? $billingInfo->fname.' '.$billingInfo->lname : '').'<br>
                                '.(isset($billingInfo->address) ? $billingInfo->address.' '.$billingInfo->address2 : '').'<br>
                                '.(isset($billingInfo->city) ? $billingInfo->city.', '.$billingInfo->state.', '.$billingInfo->zip : '').'<br>
                                '.(isset($billingInfo->phone) ? "Tel: ".$billingInfo->phone.'<br>' : '').'
                                '.(isset($billingInfo->uemail) ? "Email: ".$billingInfo->uemail : '').'</td>
                            </tr>
                        </table>
                    </div>';
                }
                $html .= '<tr>
                    <td>'.$quote->images_count.'</td>
                    <td>'.$payment.'('.$quote->currency.')</td>
                    <td>'.$status.'</td>
                    <td>'.date('F j, Y', strtotime($quote->created_at)).'</td>
                    <td>'.$button.'</td>
                </tr>';
            }
        } else {
            $html .= '<tr>
                <td colspan="5">No record found.</td>
            </tr>';
        }
        echo json_encode(array('data' => $html));
        die;
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function store(Request $request){
        header('Access-Control-Allow-Origin: *');
        $images = $request->file('file');
        $quote_id = $request->get('data');
        if(count($images) > 0){
            $path = public_path('images/'.$quote_id);
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }
            foreach ($images as $key => $image) {
                $filename = $image->getClientOriginalName();
                $imageName = time().'-'.$filename;
                $image->move($path, $imageName);
                $records[] = array('quote_id'=>$quote_id,'type' => 'client', 'url' => $imageName);
            }
            // $hasData = Media::where('quote_id', $quote_id)->firstOrFail();
            // print_r($hasData);
            // if(!$hasData) {
                Media::insert($records); // Eloquent approach
            //}
        }
        die;
    }

    public function quoteImages($quote_id)
    {
        $gallery = Media::where('type','upload')->where('quote_id',$quote_id)->get();
        $client_gal = Media::where('type','client')->where('quote_id',$quote_id)->get();
        return view('admin/view-image')->with(['gallery' => $gallery, 'client' => $client_gal, 'qid' => $quote_id]);
    }

    public function uploadImages($quote_id,Request $request)
    {
        $images = $request->file('file');
        $records = array();
        $allImages = array();
        if(count($images) > 0){
            $path = public_path('images/'.$quote_id);
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }
            foreach ($images as $key => $image) {
                $filename = $image->getClientOriginalName();
                $imageName = time().'-'.$filename;
                $image->move($path, $imageName);
                $records[] = array('quote_id'=>$quote_id,'type' => 'upload', 'url' => $imageName);
            }
            Media::insert($records); // Eloquent approach
        }
        
        return response()->json(['success'=>$allImages]);
    }

    public function notifyUser($request_id)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: *');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With,Authorization,  Content-Type, Accept');
        $quote_id = $request_id;
        // Sending mail
        $quote = DB::table('quotes')->select('*')->where('id',$quote_id)->get();
        $sel_service = json_decode($quote[0]->services);
        $info = array(
            'fname' => $quote[0]->fname,
            'lname' => $quote[0]->lname,
            'quote_id' => $quote_id,
            'email' => $quote[0]->email,
            'image_quantity' => ucfirst($quote[0]->image_complexity),
            'straighten' => isset($sel_service->straighten) ? 'Yes' : 'No',
            'resize' => isset($sel_service->resize) ? $sel_service->resize_dimensions->image_width.'x'.$sel_service->resize_dimensions->image_height : 'No',
            'comments' => $quote[0]->comment,
            'file_format' => $quote[0]->file_type,
            'subject' => 'Thank you for contacting us!',
            'type' => 'thankyou'
        );

        $infoAdmin = array(
            'fname' => $quote[0]->fname,
            'lname' => $quote[0]->lname,
            'quote_id' => $quote_id,
            'email' => $quote[0]->email,
            'image_quantity' => ucfirst($quote[0]->image_complexity),
            'straighten' => isset($sel_service->straighten) ? 'Yes' : 'No',
            'resize' => isset($sel_service->resize) ? $sel_service->resize_dimensions->image_width.'x'.$sel_service->resize_dimensions->image_height : 'No',
            'comments' => $quote[0]->comment,
            'file_format' => $quote[0]->file_type,
            'folder_path' => 'https://www.bigturn.io/view-images/'.$quote_id,
            'subject' => 'A new image resize request!',
            'type' => 'neworder'
        );
        
        Mail::to($quote[0]->email)->send(new \App\Mail\SendQuotationEmail($info));
        Mail::to('info@bigturntables.com')->send(new \App\Mail\SendQuotationEmail($infoAdmin));
        //echo "mail sent";
    }

    public function sendEmail(Request $request){
        // Sending mail
        $quote_id = $request->get('quid');
        $quote = DB::table('quotes')->select(['fname','lname','email'])->where('id',$quote_id)->get();
        $info = array(
            'name' => $quote[0]->fname.' '.$quote[0]->lname,
            'subject' => 'Modified images are ready to download!',
            'type' => 'download'
        );
        
        Mail::to($quote[0]->email)->send(new \App\Mail\SendQuotationEmail($info));
        return response()->json(['success'=>'Email sent']);
    }

    public function deleteImages(Request $request){
        $images = $request->get('del');
        if(count($images) > 0){
            $DBimages = Media::findMany($images);
            if(!empty($DBimages)){
                foreach($DBimages as $img){
                    $path = public_path('images/'.$img->quote_id.'/'.$img->url);
                    @unlink($path);
                }
            }
            Media::whereIn('id', $images)->delete();
        }
        return response()->json(['success'=>'true']);
    }
}
