@extends('admin.layout.main')
@section('content')
    <style>
        body {
            font-size: 14px;
            font-family: Poppins, Helvetica, sans-serif;
            font-weight: 400;
            line-height: 1.5;
            color: #1b1b28;
        }

        .table td,
        .table th {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

    </style>
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                {{-- start --}}
                <div class="card mt-2">
                    <div class="card-header">
                        <h1 class="h3 fs-16 mb-0">Order Details</h1>
                    </div>

                    @php
                        $data = json_decode(json_encode($order_summary));
                    @endphp

                    {{-- card body --}}
                    <div class="card-body">
                        <div class="row gutters-5">
                            @if ($data->status_id > 0)
                                <div class="col-md-3 ml-auto">
                                    <label for="update_delivery_status">Order Status</label>
                                    <select class="form-control aiz-selectpicker" data-minimum-results-for-search="Infinity"
                                        id="update_order_status">
                                        <option value="">--Select--</option>
                                        @foreach ($order_status as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $data->status_id == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="col-md-3 ml-auto">
                                <label for="update_delivery_point_status">Payment Status</label>
                                <select class="form-control aiz-selectpicker" data-minimum-results-for-search="Infinity"
                                    id="update_payment_status">
                                    <option value="0" {{ $data->payment_status == 0 ? 'selected' : '' }}>Unpaid</option>
                                    <option value="1" {{ $data->payment_status == 1 ? 'selected' : '' }}>Paid</option>
                                </select>
                            </div>

                            @if ($data->status_id == 0)
                                <div class="col-md-3 ml-auto">
                                    <label for="update_delivery_point_status">Order Status</label>
                                    <select class="form-control aiz-selectpicker" data-minimum-results-for-search="Infinity"
                                        id="update_self_pick_order_status">
                                        <option value="">--Select--</option>
                                        <option value="5" {{ $data->self_pick_order_status == 5 ? 'selected' : '' }}>
                                            Complete</option>
                                        <option value="6" {{ $data->self_pick_order_status == 6 ? 'selected' : '' }}>
                                            Cancelled</option>
                                    </select>
                                </div>

                                <div class="col-md-3 ml-auto">
                                    <label for="update_delivery_point_status">Pick Up Point</label>
                                    <select class="form-control aiz-selectpicker" data-minimum-results-for-search="Infinity"
                                        id="update_pick_point_status">
                                        <option value="">--Select--</option>
                                        @foreach ($branch as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $data->in_house_status == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>

                        {{-- address --}}
                        <div class="row gutters-5">
                            <div class="col text-center text-md-left">
                                <td class="strong small gry-color">Ship to:</td>
                                <address>
                                    <strong class="text-main">
                                        {{ $data->name }}
                                    </strong><br>
                                    {{ $data->email }}<br>
                                    {{ $data->phone }}<br>
                                    {{ $data->shipping_address }},
                                </address>
                            </div>
                            <div class="col text-center text-md-left">
                                <td class="strong small gry-color">Bill to:</td>
                                <address>
                                    <strong class="text-main">
                                        {{ $data->name }}
                                    </strong><br>
                                    {{ $data->email }}<br>
                                    {{ $data->phone }}<br>
                                    {{ $data->billing_address }},
                                </address>

                            </div>
                            <div class="col-md-4 ml-auto">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="text-main text-bold">Order #</td>
                                            <td class="text-right text-info text-bold">{{ $data->order_no }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-main text-bold">Order Status</td>
                                            <td class="text-right">
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
                                                        <span class="badge badge-inline badge-success">Complete</span>
                                                    @elseif($data->self_pick_order_status == 6)
                                                        <span class="badge badge-inline badge-danger">Cancelled</span>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-main text-bold">Payment status</td>
                                            <td class="text-right">
                                                @if ($data->payment_status == 1)
                                                    <span class="badge badge-inline badge-success">Paid</span>
                                                @else
                                                    <span class="badge badge-inline badge-danger">Unpaid</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-main text-bold">Order Date</td>
                                            <td class="text-right">
                                                {{ date('d-m-Y h:i A', strtotime($data->order_date)) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-main text-bold">
                                                Total amount
                                            </td>
                                            <td class="text-right">
                                                ${{ $data->total_amount }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-main text-bold">Payment method</td>
                                            <td class="text-right">
                                                {{ $data->payment_method }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- end address --}}
                        <hr class="new-section-sm bord-no">
                        {{-- order list --}}
                        <div class="row">
                            <div class="col-lg-12 table-responsive">
                                <table class="table table-bordered aiz-table invoice-summary">
                                    <thead>
                                        <tr class="bg-trans-dark">
                                            <th data-breakpoints="lg" class="min-col">#</th>
                                            <th width="10%">Photo</th>
                                            <th class="text-uppercase">Product Name</th>
                                            <th data-breakpoints="lg" class="text-uppercase">
                                                Delivery Type</th>
                                            <th data-breakpoints="lg" class="min-col text-center text-uppercase">
                                                Qty</th>
                                            <th data-breakpoints="lg" class="min-col text-center text-uppercase">
                                                Price</th>
                                            <th data-breakpoints="lg" class="min-col text-right text-uppercase">
                                                Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order_details as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <img src="{{ asset($item->image) }}" alt="" class="img-fluid">
                                                </td>
                                                <td>
                                                    {{ $item->title }}
                                                </td>
                                                <td>
                                                    {{ $item->shipping_method }}
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
                        {{-- end order list --}}

                        {{-- footer --}}
                        <div class="clearfix float-right">
                            <table class="table">
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
                            {{-- end footer --}}
                            <div class="text-right no-print">
                                <a href="{{ route('admin.invoice.show', $data->order_id) }}" type="button"
                                    class="btn btn-icon btn-light"><i class="las la-print"></i></a>
                            </div>
                        </div>
                        {{-- end card body --}}


                    </div>
                    {{-- end --}}
                </div>
        </section>
    </div>

    <div id="order_details_loder" style="display: none">
        @include('admin.loder.index')
    </div>

@section('javascript')
    <script>
        $('#update_payment_status').change(function() {
            var status = $(this).val();
            $.ajax({
                url: "{{ URL::signedRoute('admin.orders.change_status') }}",
                type: 'post',
                data: {
                    status_id: status,
                    order_id: "{{ request()->id }}",
                    _token: "{{ csrf_token() }}",
                    update_payment: 1
                },
                dataType: 'json',
                cache: false,
                beforeSend: function() {
                    $('#order_details_loder').show()
                },
                success: function(data) {
                    if (data.status == 'success') {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'bottom-start',
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
                    $('#order_details_loder').hide()
                },
                error: function(error) {
                    $('#order_details_loder').hide()
                    console.log(data)
                }
            });
        })

        $('#update_pick_point_status').change(function() {
            var status = $(this).val();
            $.ajax({
                url: "{{ URL::signedRoute('admin.orders.change_status') }}",
                type: 'post',
                data: {
                    status_id: status,
                    order_id: "{{ request()->id }}",
                    _token: "{{ csrf_token() }}",
                    update_pick_point: 1
                },
                dataType: 'json',
                cache: false,
                beforeSend: function() {
                    $('#order_details_loder').show()
                },
                success: function(data) {
                    if (data.status == 'success') {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'bottom-start',
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
                    $('#order_details_loder').hide()
                },
                error: function(error) {
                    $('#order_details_loder').hide()
                    console.log(data)
                }
            });
        })

        $('#update_order_status').change(function() {
            var status = $(this).val();
            $.ajax({
                url: "{{ URL::signedRoute('admin.orders.change_status') }}",
                type: 'post',
                data: {
                    status_id: status,
                    order_id: "{{ request()->id }}",
                    _token: "{{ csrf_token() }}",
                    update_order_status: 1
                },
                dataType: 'json',
                cache: false,
                beforeSend: function() {
                    $('#order_details_loder').show()
                },
                success: function(data) {
                    if (data.status == 'success') {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'bottom-start',
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
                    $('#order_details_loder').hide()
                },
                error: function(error) {
                    $('#order_details_loder').hide()
                    console.log(data)
                }
            });
        });
        $('#update_self_pick_order_status').change(function() {
            var status = $(this).val();
            $.ajax({
                url: "{{ URL::signedRoute('admin.orders.change_status') }}",
                type: 'post',
                data: {
                    status_id: status,
                    order_id: "{{ request()->id }}",
                    _token: "{{ csrf_token() }}",
                    update_self_pick_order_status: 1
                },
                dataType: 'json',
                cache: false,
                beforeSend: function() {
                    $('#order_details_loder').show()
                },
                success: function(data) {
                    if (data.status == 'success') {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'bottom-start',
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
                    $('#order_details_loder').hide()
                },
                error: function(error) {
                    $('#order_details_loder').hide()
                    console.log(data)
                }
            });
        });
    </script>
@endsection
@endsection
