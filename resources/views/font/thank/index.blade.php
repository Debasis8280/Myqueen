@extends('font.layouts.main')
@section('content')
    <style>
        td {
            font-weight: bold;
        }

    </style>
    <main class="main single-product">
        <div class="page-content mb-10 pb-6">
            <div class="container">
                <section class="">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-8 mx-auto">
                                <div class="row aiz-steps arrow-divider">
                                    <div class="col active">
                                        <div class="text-center text-primary">
                                            <i class="la-3x mb-2 las la-check-circle"></i>
                                            <h3 class="fs-14 fw-600 d-none d-lg-block"> Confirmation
                                            </h3>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>


                @php
                    $data = json_decode(json_encode($order_summary));
                @endphp
                <section class="py-4">
                    <div class="container text-left">
                        <div class="row">
                            <div class="col-xl-8 mx-auto">
                                <div class="card shadow-sm border-0 rounded">
                                    <div class="card-body">
                                        <div class="text-center py-4 mb-4">
                                            <i class="la la-check-circle la-3x text-success mb-3"></i>
                                            <h1 class="h3 mb-3 fw-600">Thank You for Your Order!</h1>
                                            <h2 class="h5">Order Code: <span
                                                    class="fw-700 text-primary">Code</span></h2>
                                            <p class="opacity-70 font-italic">
                                                A copy or your order summary has been sent to
                                                Email</p>
                                        </div>
                                        <div class="mb-4">
                                            <h5 class="fw-600 mb-3 fs-17 pb-2">Order Summary</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <table class="table">
                                                        <tr>
                                                            <td class="w-50 fw-600">Order Code:</td>
                                                            <td>{{ $data->order_no }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-50 fw-600">Name:</td>
                                                            <td>{{ $data->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-50 fw-600">Email:</td>
                                                            <td>{{ $data->email }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-50 fw-600">Shipping address:</td>
                                                            <td>{{ $data->shipping_address }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <table class="table">
                                                        <tr>
                                                            <td class="w-50 fw-600">Order date:</td>
                                                            <td>{{ $data->order_date }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-50 fw-600">Order status:</td>
                                                            <td>{{ $data->order_status }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-50 fw-600">Total order amount:</td>
                                                            <td>{{ $data->total_order_amount }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-50 fw-600">Shipping:</td>
                                                            <td>{{ $data->shipping }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-50 fw-600">Payment method</td>
                                                            <td>{{ $data->payment_method }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="fw-600 mb-3 fs-17 pb-2">Order Details</h5>
                                            <div>
                                                <table class="table table-responsive-md">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th width="30%">Product</th>
                                                            <th>Name</th>
                                                            <th>Quantity</th>
                                                            <th>Delivery Type</th>
                                                            <th class="text-right">Price</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($order_details as $key => $item)
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>
                                                                    <img src="{{ asset($item->image) }}" alt=""
                                                                        class="img-fluid">
                                                                </td>
                                                                <td>
                                                                    {{ $item->title }}
                                                                </td>
                                                                <td>
                                                                    {{ $item->qun }}
                                                                </td>
                                                                <td>
                                                                    {{ $item->shipping_method }}
                                                                </td>
                                                                <td class="text-right">
                                                                    ${{ $item->saleprice * $item->qun }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-5 col-md-6 ml-auto mr-0">
                                                    <table class="table ">
                                                        <tbody>
                                                            <tr>
                                                                <th>Subtotal</th>
                                                                <td class="text-right">
                                                                    <span
                                                                        class="fw-600">${{ $data->sub_total }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Shipping</th>
                                                                <td class="text-right">
                                                                    <span
                                                                        class="font-italic">${{ $data->shipping_charge }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Coupon Discount</th>
                                                                <td class="text-right">
                                                                    <span
                                                                        class="font-italic">${{ $data->coupon_discount }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th><span class="fw-600">Total</span></th>
                                                                <td class="text-right">
                                                                    <strong><span>${{ $data->total_amount }}</span></strong>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <a href="{{ route('users.index') }}" class="btn btn-primary">Go To Home</a>
                            </div>

                        </div>
                    </div>
                </section>



            </div>
        </div>
    </main>

@section('javascript')
    <script>
        $(document).ready(function() {
            setTimeout(() => {
                $('body').addClass('mainloaded')
            }, [1000])
        });
    </script>
@endsection
@endsection
