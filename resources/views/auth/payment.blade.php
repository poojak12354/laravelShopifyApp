@extends('layouts.withoutheader')

@section('content')
<style type="text/css">
        .panel-title {
        display: inline;
        font-weight: bold;
        }
        .display-table {
            display: table;
        }
        .display-tr {
            display: table-row;
        }
        .display-td {
            display: table-cell;
            vertical-align: middle;
            width: 61%;
        }
    </style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card payment-card">
                <div class="card-header">{{ __('Payment') }}</div>
                <div class="card-body">
                    @php
                    $services = json_decode($quoteDetail[0]->services);
                    @endphp
                    <div id="step1">
                        <div class="row">
                            <div class="col-md-8">
                                <p>First, adjust the settings to get a final price. Then we'll take you to place your order</p>
                                <hr/>
                                <p>Your edited images will be emailed to you within 48 hours.</p>
                                <div class="form-group left-form-group">
                                    <label class="form-label label-left">How many images do you need edited?*</label>
                                    <div class="qty-images">{{ $quoteDetail[0]->images_count }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 order-col-tble">
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
                                                    <td>{{ $quoteDetail[0]->images_count }}</td>
                                                    <td>{{ $quoteDetail[0]->amount_payable }} {{ $quoteDetail[0]->currency }}</td>
                                                    <td>{{ $quoteDetail[0]->amount_payable }} {{ $quoteDetail[0]->currency }}</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4" class="text-end sb-ttl">
                                                        <label class="ttl">Subtotal: </label> {{ $quoteDetail[0]->amount_payable }} {{ $quoteDetail[0]->currency }}
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="row mt-3 images-desc">
                                    <div class="col-md-6">
                                        <div class="form-group img-file">
                                            <label class="form-label">Return File Format*</label>
                                            <div class="jpg-file">JPG</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group img-file">
                                            <label class="form-label">Background Option*</label>
                                            <div class="jpg-file">White Background</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group img-file layer-ot">
                                            <label class="form-label">Layer Option*</label>
                                            <div class="jpg-file">Single layer</div>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                @php
                                $allservices = $quoteDetail[0]->services ? json_decode($quoteDetail[0]->services) : '';
                                @endphp
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group img-size1">
                                            <div class="form-check form-check-danger">
                                                <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" id="straighten" {{ isset($allservices->straighten) ? 'checked=checked' : '' }}> Straighten, crop and set margin(FREE) <i class="input-helper"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group img-size">
                                            <div class="form-grop-radio-text"><label class="form-label">Resize</label></div>
                                            <div class="form-grop-radio">
                                                 <div class="form-check form-check-danger">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="resize" id="resize_yes" {{ isset($allservices->straighten) ? 'checked=checked' : '' }} value="Yes"> Yes <i class="input-helper"></i>
                                                </label>
                                            </div>
                                                                                            <div class="form-check form-check-danger right-radio-btn">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="resize" id="resize_no" {{ !isset($allservices->straighten) ? 'checked=checked' : '' }} value="No"> No <i class="input-helper"></i>
                                                </label>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 right-side-column">
                                <div class="form-group row right-side-row">
                                    <label class="col-sm-6 col-form-label price-ttl">Your Subtotal</label>
                                    <label class="col-sm-6 col-form-label price-text">{{ $quoteDetail[0]->amount_payable }} {{ $quoteDetail[0]->currency }}</label>
                                </div>
                                <fieldset class="border row mb-3">
                                    <div class="col-md-12 mt-3 right-add">
                                        <h4>Quote For</h4>
                                        <span><b>Mike Lipka</b></span>
                                        <p>
                                        JM Trading Post, LLC dba 
                                        The House of Trade,
                                        4645 Lucca Drive
                                        Longmont,Colorado
                                        80503,United States</p>
                                    </div>
                                </fieldset>
                                <fieldset class="border row right-add">
                                    <div class="col-md-12 mt-3">
                                        <h4>Quote No. #Q{{ $quoteDetail[0]->id }}</h4>
                                        <p>Status: Ready<br/>
                                        Date: {{ date('F j, Y', strtotime(date('Y-m-d'). ' + 2 days')) }}<br/></p>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" id="btn_addtocart" class="btn btn-gradient-danger btn-fw buttn-app">Add To Cart</button>
                                
                            </div>
                        </div>
                    </div>
                    <div id="step2" style="display:none;">
                        <div class="row">
                            <div class="col-md-12 cart-contnt">
                                <h3>My Shopping Cart</h3>
                            </div>
                            <div class="col-md-8">
                                <fieldset class="border">
                                    <div class="row p-3">
                                        <div class="col-md-10">
                                            <div class="form-group mt-3 right-add">
                                                <h4>Services</h4>
                                                <label>Clipping Path x {{ $quoteDetail[0]->images_count }}</label>
                                            </div>
                                            <div class="form-group mt-3 right-add rightadd1">
                                                <h4>Order details</h4>
                                                <label>Return file format: <span class="hight-light">JPG, White background, Single layer</span></label><br>
                                                <label>Set Margin: <span id="set_margin" class="hight-light"></span></label><br>
                                                <label>Resize Image: <span id="resize_image" class="hight-light"></span></label>
                                            </div>
                                            <div class="form-group mt-3 right-add ">
                                                <h4>Additional Comments</h4>
                                                <textarea id="addition_comments" name="addition_comments" class="form-control">{{ $quoteDetail[0]->comment }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mt-3">
                                            <a href="javascript:void(0)" data-id="step1" class="prevstep">Edit</a>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-4  mt-3">
                                <div class="form-group row">
                                    <label class="col-sm-6 col-form-label rightadd2">Your Subtotal <p class="price-inn">(24 hours turnaround)</p> </label>
                                   
                                    <label class="col-sm-6 col-form-label rightadd3">{{ $quoteDetail[0]->amount_payable }} {{ $quoteDetail[0]->currency }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="button" id="btn_proceed" class="btn btn-gradient-danger btn-fw">Proceed to Checkout</button>
                            </div>
                        </div>
                    </div>
                    <div id="step3" style="display:none;">
                        <div class="row">
                            <div class="col-md-12 cart-contnt">
                                <h3>Contact Information</h3>
                            </div>
                            <div class="col-md-8">
                                <div class="border-right right-add contact-info">
                                    <h4>Billing Address</h4>
                                    <form id="billingInfo">
                                        <input type="hidden" name="amt" id="amt" value="{{$quoteDetail[0]->amount_payable}}"/>
                                        <input type="hidden" name="cur" id="cur" value="{{$quoteDetail[0]->currency}}"/>
                                        <input type="hidden" name="uemail" id="uemail" value="{{ $quoteDetail[0]->email }}"/>
                                        <input type="hidden" name="qid" id="qid" value="{{ $quoteDetail[0]->id }}"/>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group contact-deatils">
                                                    <input type="text" id="fname" name="fname" class="form-control required" placeholder="First Name" value="{{ $quoteDetail[0]->fname }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group contact-deatils">
                                                    <input type="text" id="lname" name="lname" class="form-control required" placeholder="Last Name" value="{{ $quoteDetail[0]->lname }}">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group contact-deatils">
                                                    <input type="text" id="company" name="company" class="form-control" placeholder="Company (Optional)">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group contact-deatils">
                                                    <input type="text" id="address" name="address" class="form-control required" placeholder="Address">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group contact-deatils">
                                                    <input type="text" class="form-control" id="address2" name="address2" placeholder="Apartment, suite, etc. (optional)">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row state-details">
                                                    <div class="col-md-4">
                                                        <div class="form-group contact-deatils">
                                                            <input type="text" class="form-control required" id="city" name="city" placeholder="City">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group contact-deatils select-contact">
                                                            <select class="form-control required" name="state" id="state">
                                                                <option value="">State</option>
                                                                <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                                                <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                                <option value="Assam">Assam</option>
                                                                <option value="Bihar">Bihar</option>
                                                                <option value="Chandigarh">Chandigarh</option>
                                                                <option value="Chhattisgarh">Chhattisgarh</option>
                                                                <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
                                                                <option value="Daman and Diu">Daman and Diu</option>
                                                                <option value="Delhi">Delhi</option>
                                                                <option value="Goa">Goa</option>
                                                                <option value="Gujarat">Gujarat</option>
                                                                <option value="Haryana">Haryana</option>
                                                                <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                                <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                                                <option value="Jharkhand">Jharkhand</option>
                                                                <option value="Karnataka">Karnataka</option>
                                                                <option value="Kerala">Kerala</option>
                                                                <option value="Ladakh">Ladakh</option>
                                                                <option value="Lakshadweep">Lakshadweep</option>
                                                                <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                                <option value="Maharashtra">Maharashtra</option>
                                                                <option value="Manipur">Manipur</option>
                                                                <option value="Meghalaya">Meghalaya</option>
                                                                <option value="Mizoram">Mizoram</option>
                                                                <option value="Nagaland">Nagaland</option>
                                                                <option value="Odisha">Odisha</option>
                                                                <option value="Puducherry">Puducherry</option>
                                                                <option value="Punjab">Punjab</option>
                                                                <option value="Rajasthan">Rajasthan</option>
                                                                <option value="Sikkim">Sikkim</option>
                                                                <option value="Tamil Nadu">Tamil Nadu</option>
                                                                <option value="Telangana">Telangana</option>
                                                                <option value="Tripura">Tripura</option>
                                                                <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                                <option value="Uttarakhand">Uttarakhand</option>
                                                                <option value="West Bengal">West Bengal</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group contact-deatils">
                                                            <input type="text" class="form-control required" id="zip" name="zip" placeholder="Zipcode">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group contact-deatils">
                                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone (optional)">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-4  mt-3">
                                <table class="table table-stripped">
                                    <tr>
                                        <td>Clipping Path<br>x {{ $quoteDetail[0]->images_count }}</td>
                                        <td>{{ $quoteDetail[0]->amount_payable }} {{ $quoteDetail[0]->currency }}</td>
                                    </tr>
                                    <tr>
                                        <td>Subtotal</td>
                                        <td>{{ $quoteDetail[0]->amount_payable }} {{ $quoteDetail[0]->currency }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="javascript:void(0)" data-id="step2" class="prevstep">Return to Cart</a>
                                <button type="button" id="btn_continue" class="btn btn-gradient-danger btn-fw">Continue to Payment</button>
                            </div>
                        </div>
                    </div>
                    <div id="step4" style="display:none;">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Payment Information</h4>
                                <div class="display-td pay-card" >                            
                                    <img class="img-responsive pull-right" src="{{ url('assets/images/cards.png') }}" style="height:40px;width:auto;">
                                </div>
                            </div>
                            <div class="co-md-12 pay-form">
                                <form role="form" action="#" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="" id="payment-form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group contact-deatils">
                                                <input type="text" autocomplete id="name_on_card" name="name_on_card" size='4' class="form-control required" placeholder="Name on Card">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group contact-deatils">
                                                <input type="text" id="card_num" autocomplete='off' name="card_num" size='20' class="form-control card-number required" placeholder="Card Number">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group cvc required contact-deatils">
                                                <input type="text" id="cvv" name="cvv" size='4' class="form-control card-cvc required" placeholder="CVV ex. 311">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group expiration required contact-deatils">
                                                <input type="text" id="expiry" autocomplete='off' name="expiry" size='2' class="form-control card-expiry-month required" placeholder="Expiration Month ex. 08">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group expiration required contact-deatils">
                                                <input type="text" id="expiry" autocomplete='off' name="expiry" size='4' class="form-control card-expiry-year required" placeholder="Expiration Year ex. 2022">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <button class="btn btn-gradient-danger btn-fw" type="button" id='makepayment'>Make Payment</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    var wss_code = "{{ base64_encode(env('STRIPE_KEY')) }}";
    var ajax_url = "{{ route('payment.post') }}";
</script>
<script src="{{ url('assets/js/cart.js') }}" defer></script>
@endsection
