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
                    <div id="step1">
                        <div class="row">
                            <div class="col-md-12 pay-msg">
                                <h3>You have already paid for your request. Kindly create a new request to make payment.</h3>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
