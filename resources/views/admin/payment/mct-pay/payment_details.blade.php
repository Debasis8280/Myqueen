@extends('admin.layout.main')
@section('content')
    <link rel="stylesheet" href="{{ asset('asset/css/mycss.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/font/order_tracker.css') }}">
    <style>
        .btn-sm.btn-icon {
            padding: 1.416rem;
        }

        .btn i {
            display: inline-block;
            vertical-align: middle;
            margin-left: -0.9rem;
            margin-top: -1.9rem;
            line-height: 0;
            font-size: 1.9rem;
        }

        .card .card-header {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            position: relative;
            padding: 12px 25px;
            border-bottom: 1px solid #ebedf2;
            min-height: 50px;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
            background-color: transparent;
        }

        .mb-0,
        .my-0 {
            margin-bottom: 0 !important;
        }

        .h6,
        h6 {
            font-size: 2rem;
            font-weight: bold;
            line-height: 1.2;
        }

        .bold {
            font-weight: bold;
        }

        td {
            font-size: 15px;
        }

    </style>
    @php
    $data = json_decode(json_encode($order_summary));
    @endphp
    <div class="content-wrapper">
        <div class="container-fluid">

            <main class="main mt-6 single-product">
                <div class="page-content mb-10 pb-6">
                    <div class="container">
                        <div class="row">
                            <div class="card mt-4  col-lg-12">
                                <div class="card-header">
                                    <b class="fs-15">Payment Summary</b>
                                    <a href="#!" class="btn btn-primary float-right" onclick="approve_mct_payment()">Approve
                                        Payment</a>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="w-50 fw-600 bold">Total Amount:</td>
                                                    <td>${{ $data->total_amount }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-50 fw-600 bold">Payment Date:</td>
                                                    <td>{{ date($data->payment_date) }}</td>
                                                </tr>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="card mt-4  col-lg-12">
                                <div class="card-header">
                                    <b class="fs-15">Order Summary</b>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="w-50 fw-600 bold">Order Code:</td>
                                                    <td>{{ $data->order_no }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-50 fw-600 bold">Customer:</td>
                                                    <td>{{ $data->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-50 fw-600 bold">Email:</td>
                                                    <td>
                                                        {{ $data->email }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="w-50 fw-600 bold">Shipping address:</td>
                                                    <td>
                                                        {{ $data->shipping_address }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="w-50 fw-600 bold">Order date:</td>
                                                    <td>
                                                        {{ $data->order_date }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="w-50 fw-600 bold">Order status:</td>
                                                    <td>
                                                        @if ($data->status_id == 1)
                                                            <span class="badge badge-inline badge-primary">Processing</span>
                                                        @elseif($data->status_id == 2)
                                                            <span class="badge badge-inline badge-dark">Order Placed
                                                            </span>
                                                        @elseif($data->status_id == 3)
                                                            <span class="badge badge-inline badge-info">In transit</span>
                                                        @elseif($data->status_id == 4)
                                                            <span class="badge badge-inline badge-success">On The Way</span>
                                                        @elseif($data->status_id == 5)
                                                            <span class="badge badge-inline badge-success">Delivered</span>
                                                        @elseif($data->status_id == 6)
                                                            <span class="badge badge-inline badge-danger">Cancelled</span>
                                                        @else
                                                            <span class="badge badge-inline badge-success">Slef Pick</span>
                                                            @if ($data->self_pick_order_status == 5)
                                                                <span
                                                                    class="badge badge-inline badge-success">Complete</span>
                                                            @elseif($data->self_pick_order_status == 6)
                                                                <span
                                                                    class="badge badge-inline badge-danger">Cancelled</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="w-50 fw-600 bold">Total order amount:</td>
                                                    <td>
                                                        ${{ $data->total_amount }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="w-50 fw-600 bold">Shipping method:</td>
                                                    <td>{{ $data->shipping_method }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-50 fw-600 bold">Payment method:</td>
                                                    <td>{{ $data->payment_method }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-9">
                                <div class="card mt-4">
                                    <div class="card-header">
                                        <b class="fs-15">Order Details</b>
                                    </div>
                                    <div class="card-body pb-0">
                                        <table class="table table-borderless table-responsive">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th width="30%">Product</th>
                                                    <th>Name</th>
                                                    <th>Quantity</th>
                                                    <th>Delivery Type</th>
                                                    <th>Price</th>
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
                                                        <td class="">
                                                            ${{ $item->saleprice * $item->qun }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="card mt-4">
                                    <div class="card-header">
                                        <b class="fs-15">Order Ammount</b>
                                        @if ($data->payment_status == 1)
                                            <span class="badge badge-inline badge-success">Approve</span>
                                        @else
                                            <span class="badge badge-inline badge-danger">Pending</span>
                                        @endif
                                    </div>
                                    <div class="card-body pb-0">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td class="w-50 fw-600 bold">Subtotal</td>
                                                    <td class="text-right">
                                                        <span class="strong-600">${{ $data->sub_total }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="w-50 fw-600 bold">Shipping</td>
                                                    <td class="text-right">
                                                        <span class="text-italic">${{ $data->shipping_charge }}</span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="w-50 fw-600 bold">Coupon</td>
                                                    <td class="text-right">
                                                        <span class="text-italic">${{ $data->coupon_discount }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="w-50 fw-600 bold">Total</td>
                                                    <td class="text-right bold">
                                                        <strong><span>${{ $data->total_amount }}</span></strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            @if ($data->status_id == 0 && $data->in_house_status != null)
                                <div class="col-lg-9">
                                    <div class="card mt-4">
                                        <div class="card-header">
                                            <b class="fs-15">Branch Details</b>
                                        </div>
                                        <div class="card-body pb-0">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td class="w-50 fw-600 bold">Name</td>
                                                        <td class="text-right">
                                                            <span class="strong-600">{{ $data->branch_name }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="w-50 fw-600 bold">Address</td>
                                                        <td class="text-right">
                                                            <span
                                                                class="text-italic">{{ $data->branch_address }}</span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="w-50 fw-600 bold">Zip</td>
                                                        <td class="text-right">
                                                            <span class="text-italic">{{ $data->branch_zip }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="w-50 fw-600 bold">Country</td>
                                                        <td class="text-right bold">
                                                            <strong><span>{{ $data->branch_country }}</span></strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($data->status_id > 0)
                                <div class="col-lg-12">
                                    <div class="card mt-4">
                                        <div class="card-header">
                                            <b class="fs-15">Order Ship Details</b>
                                        </div>
                                        <div class="card-body pb-0">
                                            <div class="card card-timeline px-2 border-none">
                                                <ul class="bs4-order-tracking">
                                                    <li class="step active">
                                                        <div><i class="fas fa-hourglass-half"></i></i></div> Processing
                                                    </li>
                                                    <li class="step  @if ($data->status_id >= 2) active @endif">
                                                        <div><i class="fas fa-user"></i></div> Order Placed
                                                    </li>
                                                    <li class="step @if ($data->status_id >= 3) active @endif">
                                                        <div><i class="fas fa-bread-slice"></i></div> In transit
                                                    </li>
                                                    <li class="step @if ($data->status_id >= 4) active @endif">
                                                        <div><i class="fas fa-truck"></i></div> Out for delivery
                                                    </li>
                                                    <li class="step @if ($data->status_id >= 5) active @endif">
                                                        <div><i class="fas fa-birthday-cake"></i></div> Delivered
                                                    </li>
                                                </ul>
                                                @if ($data->status_id == 1)
                                                    <h5 class="text-center"><b>In Processing</b>. The order has been
                                                        Placed!</h5>
                                                @elseif ($data->status_id == 2)
                                                    <h5 class="text-center"><b>In Placed</b>. The order has been
                                                        transit!
                                                    </h5>
                                                @elseif ($data->status_id == 3)
                                                    <h5 class="text-center"><b>In transit</b>. The order has been
                                                        shipped!</h5>
                                                @elseif ($data->status_id == 4)
                                                    <h5 class="text-center"><b>In delivery</b>. The order Out For
                                                        delivery!</h5>
                                                @else
                                                    <h5 class="text-center"><b>Delivery</b>. The order has been
                                                        Delivery!</h5>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </main>

        </div>
    </div>

    <div id="payment_approve_model" class="modal fade">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <b class="modal-title">Payment Confirmation</b>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mt-1">Are you sure to Approve this?</p>
                    <button type="button" class="btn btn-link mt-2" data-dismiss="modal">Cancel</button>
                    <a href="#!" class="btn btn-primary mt-2" onclick="approve_mct()">Approve</a>
                </div>
            </div>
        </div>
    </div>

    <div id="loder" style="display: none">
        @include('mlm.loder.index')
    </div>


@section('javascript')



    <script>
        function approve_mct_payment() {
            $('#payment_approve_model').modal('show');
        }

        function approve_mct() {
            $.ajax({
                url: "{{ URL::signedRoute('admin.mct.store') }}",
                type: 'post',
                data: {
                    id: "{{ request()->id }}",
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#loder').show()
                },
                success: function(data) {
                    if (data.status == 'success') {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })
                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        })
                    }

                    setTimeout(() => {
                        window.location.reload()
                    }, 1000);
                    $('#loder').hide()
                },
                error: function(error) {
                    console.log(error)
                    $('#loder').hide()
                }
            })
        }
    </script>
@endsection
@endsection
