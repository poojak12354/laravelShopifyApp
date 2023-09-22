@extends('layouts.withoutheader')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 col-payment">
            <div class="card payment-card">
                <div class="card-header">{{ __('Thank You') }}</div>
                <div class="card-body">
                    <div id="thankyou">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>{{ $quoteDetail->trasaction_status == 'complete' ? 'Thank you! Payment has been completed successfully' : 'Your payment status is '.$quoteDetail->trasaction_status }}.</h3>
                                <div class="row">
                                    <div class="col-md-12 col-date">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Order Number:</label><br>
                                                #{{ $quoteDetail->id }}
                                            </div>
                                            <div class="col-md-3">
                                                <label>Date:</label><br>
                                                {{ date('F j,Y',strtotime($quoteDetail->created_at)) }}
                                            </div>
                                            <div class="col-md-3">
                                                <label>Total:</label><br>
                                                {{ $quoteDetail->amount }} {{ $quoteDetail->currency }}
                                            </div>
                                            <div class="col-md-3">
                                                <label>Payment Method:</label><br>
                                                {{ __('Card') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 order-col-tble tble-spc">
                                        <h3>Order Summary</h3>
                                        <table class="table table-stripped">
                                            <thead>
                                                <tr>
                                                    <th>Service</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Total Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Clipping Path</td>
                                                    <td>{{ $quoteDetail->images_count }}</td>
                                                    <td>{{ $quoteDetail->amount }} {{ $quoteDetail->currency }}</td>
                                                    <td>{{ $quoteDetail->amount }} {{ $quoteDetail->currency }}</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4" class="text-end sb-ttl">
                                                        <label class="ttl">Subtotal: </label> {{ $quoteDetail->amount }} {{ $quoteDetail->currency }}
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="col-md-12 order-col-tble tble-spc">
                                        <h3>Billing Address</h3>
                                        <div class="border p-10 billing-dtl">
                                            @php
                                                $billingInfo = json_decode($quoteDetail->billing_info);
                                            @endphp
                                            {{ $billingInfo->fname.' '.$billingInfo->lname }}<br>
                                            {{ $billingInfo->address.' '.$billingInfo->address2 }}<br>
                                            {{ $billingInfo->city.', '.$billingInfo->state.', '.$billingInfo->zip}}<br>
                                            {{ $billingInfo->phone ? "Tel: ".$billingInfo->phone : ''}}<br>
                                            {{ $billingInfo->uemail ? "Email: ".$billingInfo->uemail : ''}}
                                        </div>
                                    </div>
                                    <a href="{{ $quoteDetail->reciept_url}}" target="_blank" class="btn btn-gradient-danger"><i class="mdi mdi-eye"></i> View Reciept</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
