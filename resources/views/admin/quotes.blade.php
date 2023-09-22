@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card quotes-card">
                <div class="card-body">
                    <h4 class="card-title">Quotes</h4>
                    <input type="hidden" name="uemail" id="uemail" value=""/>
                    <table class="table table-striped ">
                        <thead class="quote-head">
                            <tr class="quote-row1">
                                <th> Name </th>
                                <th> Email </th>
                                <th> Total Images </th>
                                <th> Amount </th>
                                <th> Status </th>
                                <th> Date </th>
                                <th>  </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($quotes) > 0)
                                @foreach ($quotes as $quote)
                                    <tr>
                                        <td>
                                            <div class="user-img"><img src="{{ url('assets/images/faces-clipart/pic-1.png') }}" alt="image"></div>
                                            <label class="user-nme">{{$quote->fname." ".$quote->lname}}</label>
                                        </td>
                                        <td>{{$quote->email}}</td>
                                        <td><label class="badge badge-info">{{$quote->images_count}}</label></td>
                                        <td>{{$quote->total_amount}} ({{$quote->currency}})</td>
                                        <td>
                                            @switch($quote->trasaction_status)
                                                @case('complete')
                                                    <label class="badge badge-gradient-success">Completed</label>
                                                @break

                                                @case('failed')
                                                    <label class="badge badge-gradient-danger">Failed</label>
                                                @break

                                                @default
                                                <label class="badge badge-gradient-warning">Unpaid</label>
                                            @endswitch
                                        </td>
                                        <td>{{ date('F j, Y', strtotime($quote->created_at)) }}</td>
                                        <td class="quote-deatils">
                                            <div class="d-none" id="tbl_dataquote">
                                                <table class="table table-striped table-striped2">
                                                    <tr>
                                                        <td>Name: </td>
                                                        <td>{{$quote->fname." ".$quote->lname}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Add-on Services: </td>
                                                        @php
                                                        $allservices = json_decode($quote->services)
                                                        @endphp
                                                        <td>@if(!empty($quote->services) && count((array)$allservices) > 0)
                                                                @if(isset($allservices->straighten))
                                                                Straighten
                                                                @endif
                                                                @if(isset($allservices->resize))
                                                                    @if(isset($allservices->straighten))
                                                                    , 
                                                                    @endif
                                                                    Resize ({{$allservices->resize_dimensions->image_width}} x {{$allservices->resize_dimensions->image_height}})
                                                                @endif
                                                            @else
                                                                None
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Required File Format: </td>
                                                        <td>{{$quote->file_type}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Comment: </td>
                                                        <td>{{$quote->comment}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Images Complexity: </td>
                                                        <td>{{$quote->image_complexity}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Images ({{$quote->images_count}}): </td>
                                                        <td>List of images</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Estimated Total ({{$quote->currency}}): </td>
                                                        <td>{{$quote->total_amount}} ({{$quote->currency}})</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <button title="View Quote" type="button" id="view_quote" class="btn btn-inverse-danger btn-icon">
                                                <i class="mdi mdi-eye"></i>
                                            </button>
                                            <button title="Send Email" type="button" id="sendMail" class="btn btn-inverse-info btn-icon" data-mail="{{$quote->email}}">
                                                <i class="mdi mdi-email"></i>
                                            </button>
                                            <button title="Send Payment Link" type="button" id="paylink" class="btn btn-inverse-dark btn-icon" data-id="{{$quote->id}}" data-mail="{{$quote->email}}" data-link="{{$quote->payment_link}}">
                                                <i class="mdi mdi-currency-usd"></i>
                                            </button>
                                            <a href="{{ url('view-images/'.$quote->id) }}" title="Upload Modified" class="btn btn-inverse-primary btn-icon spcl-link-btn">
                                                <i class="mdi mdi-cloud-upload"></i>
                                            </a>
                                            @if(isset($quote->trasaction_status) && $quote->trasaction_status != 'unpaid')
                                                <button title="View Payment Info" type="button" id="paymentInfo" class="btn btn-gradient-success btn-icon" data-id="{{$quote->id}}" data-mail="{{$quote->email}}" data-link="{{$quote->payment_link}}">
                                                <i class="mdi mdi-cash-usd"></i>
                                                </button>
                                                <div class="d-none" id="tbl_datapayment">
                                                    <h3>Invoice Number: # {{$quote->paymentId}} <a href="{{$quote->reciept_url}}" class="btn btn-inverse-dark btn-sm" target="_blank"><i class="mdi mdi-eye"></i> View Reciept</a></h3>
                                                    <table class="table table-striped table-striped2">
                                                        <tr>
                                                            <td>Total Amount: </td>
                                                            <td>{{$quote->paid_amt}} {{$quote->currency}}</td>
                                                        </tr>
                                                        @if($quote->trasaction_status == 'complete')
                                                            <tr>
                                                                <td>Transaction Id: </td>
                                                                <td>{{$quote->transaction_id}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Charge Id: </td>
                                                                <td>{{$quote->charge_id}}</td>
                                                            </tr>
                                                        @endif
                                                        <tr>
                                                            <td>Status: </td>
                                                            <td>{{$quote->trasaction_status}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Note: </td>
                                                            <td>{{$quote->comment_note}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Straighten : </td>
                                                            <td>{{ $quote->checkout_straighten ? 'Yes' : 'No'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Resize : </td>
                                                            <td>{{$quote->checkout_resize}}</td>
                                                        </tr>
                                                        <tr>
                                                            <?php  $billingInfo = json_decode($quote->billing_info);?>
                                                            <td>Billing Info: </td>
                                                            <td>{{ isset($billingInfo->fname) ? $billingInfo->fname.' '.$billingInfo->lname : '' }}<br>
                                                                {{ isset($billingInfo->address) ? $billingInfo->address.' '.$billingInfo->address2  : '' }}<br>
                                                                {{ isset($billingInfo->city) ? $billingInfo->city.', '.$billingInfo->state.', '.$billingInfo->zip  : ''}}<br>
                                                                {{ isset($billingInfo->phone) ? "Tel: ".$billingInfo->phone : ''}}<br>
                                                                {{ isset($billingInfo->uemail) ? "Email: ".$billingInfo->uemail : ''}}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="7">No record found!</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="loadDataHtml" tabindex="-1" role="dialog" aria-labelledby="loadDataHtmlLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quoteModalLabel"><i class="mdi mdi-comment-processing"></i> Quote</h5>
                    <button type="button" class="close" data-dismiss="modal" aria- 
                    label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body" id="modal_html">
                    
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="sendEmaiHtml" tabindex="-1" role="dialog" aria-labelledby="sendEmaiHtmlLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendModalLabel">Send Quotes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria- 
                    label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body" id="modal_html">
                <div class="row">
                    <div class="col-md-12">
                        <form id="frm_sendEmail">
                            <input type="hidden" name="ajax" id="ajax" value="{{ route('sendemail') }}"/>
                            <div class="form-group row">
                                <label for="emailSubject" class="col-sm-3 col-form-label">Subject</label>
                                <div class="col-sm-9">
                                    <input type="text" name="emailSubject" class="form-control" id="emailSubject" placeholder="Subject">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="emailMessage" class="col-sm-3 col-form-label">Message</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="emailMessage" name="emailMessage" rows="4" placeholder="Message"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <button type="button" id="btn_sendEmail" class="btn btn-gradient-danger me-2">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="sendPayLink" tabindex="-1" role="dialog" aria-labelledby="sendPayLink" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paylinkModalLabel">Send Payment Link</h5>
                    <button type="button" class="close" data-dismiss="modal" aria- 
                    label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body" id="modal_html">
                <div class="row">
                    <div class="col-md-12">
                        <form id="frm_sendPayEmail">
                            <input type="hidden" name="pajax" id="pajax" value="{{ route('sendpaymentlink') }}"/>
                            <input type="hidden" name="uid" id="uid" value=""/>

                            <div class="form-group row">
                                <label for="emailSubject" class="col-sm-3 col-form-label">Amount</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gradient-danger text-white">$</span>
                                        </div>
                                        <input type="text" name="amount" class="form-control" id="amount" placeholder="Amount to pay">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-gradient-danger text-white">.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <button type="button" id="btn_generate" class="btn btn-gradient-danger me-2">Generate and Send</button>
                                </div>
                            </div>
                        </form>
                        <div class="form-group d-none" id="div_payLink">
                            <div class="input-group">
                                <div class="inner-group">
                                    <input type="text" class="form-control copy-link" readonly="readonly" id="pay_link">
                                </div>
                                <div class="input-group-append inner-btn">
                                <button class="btn btn-sm btn-gradient-danger link-btn-sm" id="copyLink" type="button">
                                    <i class="mdi mdi-content-copy"></i>
                                </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ url('assets/js/quotes.js') }}" defer></script>
@endsection