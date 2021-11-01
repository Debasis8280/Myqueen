@extends('admin.layout.main')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#qrcode_pay" role="tab"
                        aria-controls="home" aria-selected="true">Pay Now</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link " id="home-tab" data-toggle="tab" href="#mct_pay" role="tab" aria-controls="home"
                        aria-selected="true">MCT Pay</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="warehouse_management-tab" data-toggle="tab" href="#top_up" role="tab"
                        aria-controls="profile" aria-selected="false">Top Up</a>
                </li>
            </ul>
            <div class="tab-content bg-white" id="myTabContent">
                <div class="tab-pane fade show active" id="qrcode_pay" role="tabpanel" aria-labelledby="generate-tab">
                    @include('admin.payment.qrcodepay.index')
                </div>
                <div class="tab-pane fade" id="mct_pay" role="tabpanel" aria-labelledby="generate-tab">
                    @include('admin.payment.mct-pay.index')
                </div>
                <div class="tab-pane fade" id="top_up" role="tabpanel" aria-labelledby="generate-tab">
                    @include('admin.payment.topup.index')
                </div>
            </div>
        </div>
    </div>
@endsection
