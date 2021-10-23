@extends('font.layouts.main')
@section('content')
    <link rel="stylesheet" href="{{ asset('asset/stepper/bs-stepper.min.css') }}">
    <style>
        .bs-stepper .bs-stepper-header .step .step-trigger {
            -webkit-flex-wrap: nowrap;
            -ms-flex-wrap: nowrap;
            flex-wrap: nowrap;
            padding: 0;
            font-weight: 400;
        }

        .bs-stepper .bs-stepper-header .step.active .step-trigger .bs-stepper-box {
            background-color: #7367F0;
            color: #FFF;
            box-shadow: 0 3px 6px 0 rgb(115 103 240 / 40%);
        }

        svg.font-medium-3 {
            height: 1.3rem !important;
            width: 1.3rem !important;
        }

        .bs-stepper .bs-stepper-header .step .step-trigger .bs-stepper-box {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            padding: .5em 0;
            font-weight: 500;
            color: #BABFC7;
            background-color: rgba(186, 191, 199, .12);
            border-radius: .35rem;
        }

        .bs-stepper .bs-stepper-header .step .step-trigger .bs-stepper-label {
            text-align: left;
            margin: .5rem 0 0 1rem;
        }

        .bs-stepper .bs-stepper-header .step.active .step-trigger .bs-stepper-label .bs-stepper-title {
            color: #7367F0;
        }

        .bs-stepper .bs-stepper-header .step .step-trigger .bs-stepper-label .bs-stepper-title {
            display: inherit;
            color: #6E6B7B;
            font-weight: 600;
            line-height: 1rem;
            margin-bottom: 0;
        }

        .mycard:hover {
            transform: translateY(-5px) scale(1.005) translateZ(0);
            box-shadow: 0 24px 36px rgba(0, 0, 0, 0.11),
                /* 0 24px 46px var(--box-shadow-color); */
        }

        .mycard:hover .overlay {
            transform: scale(4) translateZ(0);
        }

        .item-quantity {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
        }

        .item-price {
            color: #7367F0;
            margin-bottom: 0;
        }

        .price-details {
            padding: 2px;
        }

        .price-detail {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
        }

        .card .card-header .card-title {
            margin-bottom: 0;
        }

        .card .card-title {
            font-size: 1.285rem;
            margin-bottom: 1.53rem;
            font-weight: bold;
            font-size: 25px;
        }

        .card {
            box-shadow: 0 4px 24px 0 rgb(34 41 47 / 10%);
        }

        input[type="checkbox"] {
            -webkit-appearance: checkbox;
        }

    </style>
    <link rel="stylesheet" href="{{ asset('asset/bootstrap-touchspin/jquery.bootstrap-touchspin.css') }}">
    <main class="main mt-6 single-product">
        <div class="page-content mb-10 pb-6">
            <div class="container">


                <div class="bs-stepper horizontal">
                    <div class="bs-stepper-header" role="tablist">
                        <div class="step " data-target="#section-1">
                            <button type="button" class="step-trigger" aria-selected="true">
                                <span class="bs-stepper-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-shopping-cart font-medium-3">
                                        <circle cx="9" cy="21" r="1"></circle>
                                        <circle cx="20" cy="21" r="1"></circle>
                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                    </svg>
                                </span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Cart</span>
                                    <span class="bs-stepper-subtitle">Your Cart Items</span>
                                </span>
                            </button>
                        </div>

                        <div class="bs-stepper-line"></div>

                        <div class="step " data-target="#section-2">
                            <button type="button" class="step-trigger" aria-selected="true">
                                <span class="bs-stepper-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-home font-medium-3">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                    </svg>
                                </span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Address</span>
                                    <span class="bs-stepper-subtitle">Enter Your Address</span>
                                </span>
                            </button>
                        </div>

                        <div class="bs-stepper-line"></div>

                        <div class="step" data-target="#section-3">
                            <button type="button" class="step-trigger" aria-selected="false">
                                <span class="bs-stepper-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-credit-card font-medium-3">
                                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                        <line x1="1" y1="10" x2="23" y2="10"></line>
                                    </svg>
                                </span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Payment</span>
                                    <span class="bs-stepper-subtitle">Select Payment Method</span>
                                </span>
                            </button>
                        </div>

                    </div>
                    <!-- Corpo -->
                    <div class="bs-stepper-content">

                        <form id="main_order_form">
                            @csrf

                            <div id="section-1" role="tabpanel" class="bs-stepper-pane fade " aria-labelledby="trigger1">
                                @include('font.cart.cart_item')
                            </div>

                            <div id="section-2" role="tabpanel" class="bs-stepper-pane fade" aria-labelledby="trigger2">

                                <div class="row">

                                    <div class="col-sm-12">
                                        <div id="accordionWrapa10" role="tablist" aria-multiselectable="true">
                                            <div class="card collapse-icon">
                                                <div class="card-header">
                                                    <h4 class="card-title">Address</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="collapse-shadow">
                                                        <div class="card">
                                                            <div class="card-header" data-toggle="collapse" role="button"
                                                                data-target="#accordion10" aria-expanded="false"
                                                                aria-controls="accordion10" id="home_delivery_option">
                                                                <span class="lead collapse-title"
                                                                    style="font-weight: bold;font-size: 17px;"> Home
                                                                    Delivery
                                                                </span>
                                                                <input type="hidden" name="home_delivery_select"
                                                                    id="home_delivery_select">
                                                                <input type="hidden" name="self_pickup_select"
                                                                    id="self_pickup_select">
                                                            </div>
                                                            <div id="accordion10" role="tabpanel"
                                                                data-parent="#accordionWrapa10" aria-labelledby="heading11"
                                                                class="collapse">
                                                                <div class="card-body">
                                                                    @include('font.cart.home_delivery')
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header" data-toggle="collapse" role="button"
                                                                data-target="#accordion40" aria-expanded="false"
                                                                aria-controls="accordion40" id="self_pickup_option">
                                                                <span class="lead collapse-title"
                                                                    style="font-weight: bold;font-size: 17px;"> Self Pickup
                                                                </span>
                                                            </div>
                                                            <div id="accordion40" role="tabpanel"
                                                                data-parent="#accordionWrapa10" aria-labelledby="heading40"
                                                                class="collapse" aria-expanded="false">
                                                                <div class="card-body">
                                                                    <div class="row p-2">
                                                                        <div class="row">
                                                                            <label>Country / Region *</label>
                                                                            <div class="">
                                                                                <select name="country_self"
                                                                                    class="form-control"
                                                                                    id="country_self">
                                                                                    <option value="Singapore" selected>
                                                                                        Singapore
                                                                                </select>
                                                                                <span style="color: red"
                                                                                    id="country_self_error"></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-xs-6">
                                                                                <label>State *</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="state_self" id="state_self" />
                                                                                <span style="color: red"
                                                                                    id="state_self_error"></span>
                                                                            </div>
                                                                            <div class="col-xs-6">
                                                                                <label>ZIP *</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="zip_self" id="zip_self" />
                                                                                <span style="color: red"
                                                                                    id="zip_self_error"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="address_part" id="address_part">
                                <div class="controls">
                                    <button class="btn btn-primary float-left btnPrevious" type="button"
                                        id="address_previous_btn"> &#171;
                                        Previous</button>
                                </div>
                                <div class="controls">
                                    <button class="btn btn-primary float-right btnNext" type="button" id="address_btn"
                                        disabled>
                                        Next &raquo;</button>
                                </div>

                            </div>

                            <div id="section-3" role="tabpanel" class="bs-stepper-pane fade" aria-labelledby="trigger3">
                                <div class="row">

                                    <div class="col-md-8">
                                        <div class="card">
                                            <div class="card-header flex-column align-items-start">
                                                <h4 class="card-title">Payment options</h4>
                                                <p class="card-text text-muted mt-25">Be sure to click on correct payment
                                                    option
                                                </p>
                                            </div>
                                            <div class="card-body">
                                                <input type="hidden" name="last_main_part" id="last_main_part">
                                                @include('font.cart.payment_option')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card p-2">
                                            <div class="card-header">
                                                <h4 class="card-title">Price Details</h4>
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-unstyled price-details">
                                                    <li class="price-detail">
                                                        <div class="details-title">Price of items</div>
                                                        <div class="detail-amt">
                                                            <strong id="total_cart_amount_product"></strong>
                                                        </div>
                                                    </li>
                                                    <li class="price-detail" style="display: none" id="main_discount_div">
                                                        <div class="details-title">Discount</div>
                                                        <div class="detail-amt" id="discount_amount"></div>
                                                    </li>
                                                    <li class="price-detail">
                                                        <div class="details-title">Delivery Charges</div>
                                                        <div class="detail-amt discount-amt" id="delivery_charge_show">
                                                        </div>
                                                    </li>
                                                </ul>
                                                <hr>
                                                <ul class="list-unstyled price-details">
                                                    <li class="price-detail">
                                                        <div class="details-title">Amount Payable</div>
                                                        <div class="detail-amt font-weight-bolder total_cart_amount">$699.30
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="controls">
                                    <button class="btn btn-primary float-left btnPrevious" type="button"
                                        id="payment_option_previous"> &#171;
                                        Previous</button>
                                </div>
                                <div class="controls">
                                    <button class="btn btn-primary float-right" type="button" id="complete_form_submit_btn">
                                        Submit &raquo;</button>
                                </div>

                            </div>


                        </form>

                    </div>
                </div>


            </div>
        </div>
    </main>
    <div id="cart_page_loading" style="display: none">
        @include('font.loading.productLoding')
    </div>
@section('javascript')
    <script src="{{ asset('asset/stepper/bs-stepper.min.js') }}"></script>
    <script src="{{ asset('asset/bootstrap-touchspin/jquery.bootstrap-touchspin.js') }}"></script>
    @include('font.js.cardjs')

@endsection
@endsection
