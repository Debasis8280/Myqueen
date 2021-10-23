@extends('admin.layout.main')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Order list</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Product </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">

                {{-- date --}}
                <div class="row">
                    <div class="col-md-3 mt-2 ">
                        <ul class="nav nav-stacked align-items-center">
                            <li><strong>From Date</strong></li>
                            <li>
                                <input type="text" class="form-control" id="dateFrom" name="dateFrom" />
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3 mt-2">
                        <ul class="nav nav-stacked align-items-center">
                            <li><strong>To Date </strong></li>
                            <li>
                                <input type="text" class="form-control" id="dateTo" name="dateTo" />
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-1 mt-2">
                        <ul class="nav nav-stacked">
                            <li>&nbsp;</li>
                            <li>
                                <button class="btn btn-primary" type="button" id="getJsonSrc">Search</button>
                            </li>
                        </ul>
                    </div>

                    @php
                        $order_status = App\Models\OrderStatus::get();
                    @endphp
                    <div class="col-md-5">
                        <ul class="nav nav-stacked align-items-center">
                            <li><strong>Status</strong></li>
                            <li>
                                <select name="" id="order_status" class="form-control">
                                    <option value="">--Select--</option>
                                    @foreach ($order_status as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                    <option value="0">Self Pick</option>
                                </select>
                            </li>
                        </ul>
                    </div>



                </div>

                <div class="row">
                    <div class="col-md-5 mt-2">
                        <ul class="nav nav-stacked align-items-center">
                            <li><strong>Payment</strong></li>
                            <li>
                                <select name="" id="payment_status" class="form-control">
                                    <option value="">--Select--</option>
                                    <option value="0">Unpaid</option>
                                    <option value="1">Paid</option>
                                </select>
                            </li>
                        </ul>
                    </div>
                </div>
                {{-- end date --}}



                <div class="widget-box">
                    <div class="box">
                        <div class="box-body table-responsive">
                            <table id="table" data-toggle="table" data-height="460" data-ajax="showuOrders"
                                data-pagination="true" data-show-columns="true" data-show-pagination-switch="true"
                                data-show-refresh="true" data-search="true" data-show-export="true">
                                <thead>
                                    <tr>
                                        <th data-field="order_unique">Order Id</th>
                                        <th data-field="status_id" data-formatter="ordersStatus">Status</th>
                                        <th data-field="customername">Customer Name</th>
                                        <th data-field="order_sum" data-formatter="order_amount">Total Amount</th>
                                        <th data-field="discount_amount" data-formatter="discount_amount">Discount Amount
                                        </th>
                                        <th data-field="shipping_charge" data-formatter="shipping_charge">Shipping Charge
                                        </th>
                                        <th data-field="total" data-formatter="total">Total
                                        </th>
                                        <th data-field="payment_status" data-formatter="payment_status">Payment
                                        </th>
                                        <th data-field="date">Date</th>
                                        <th data-field="operate" data-formatter="ordersAction">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    </div>
                </div>
            </div>
        </section>

    </div>

    <div id="order_delete-modal" class="modal fade">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">Delete Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mt-1">Are you sure to delete this?</p>
                    <button type="button" class="btn btn-link mt-2" data-dismiss="modal">Cancel</button>
                    <a href="" id="order_delete-link" class="btn btn-primary mt-2">Delete</a>
                </div>
            </div>
        </div>
    </div>

    {{-- loder --}}
    <div id="order_list_loder" style="display: none">
        @include('admin.loder.index')
    </div>
    {{-- end loder --}}

@section('javascript')
    <script>
        $('#payment_status').change(function() {
            var $select_id = $(this).val();
            var $startDate = $("#dateFrom").val(),
                $endDate = $("#dateTo").val();

            $.ajax({
                url: "{{ URL::signedRoute('admin.orders.create') }}",
                type: 'get',
                dataType: "json",
                beforeSend: function() {
                    $('#order_list_loder').show();
                },
                success: function(data) {
                    $('#order_list_loder').hide();
                    var my_array;
                    my_array = [];
                    for (var i = 0; i < data.length; i++) {
                        var this_id = data[i].payment_status;
                        var this_date = new Date(data[i].date);
                        this_date = this_date.getFullYear() + "-" + "0" + (this_date.getMonth() + 1) +
                            "-" +
                            ("0" + this_date.getDate()).slice(-2)
                        if ((this_id == $select_id)) {
                            my_array.push(data[i]);
                        }
                        console.log(this_id == $select_id);
                    }
                    $("#table").bootstrapTable("load", my_array);
                },
                error: function(error) {
                    $('#order_list_loder').hide();
                    console.log(error);
                }
            })
        })
        // status filter
        $('#order_status').change(function() {
            var $select_id = $(this).val();
            var $startDate = $("#dateFrom").val(),
                $endDate = $("#dateTo").val();

            $.ajax({
                url: "{{ URL::signedRoute('admin.orders.create') }}",
                type: 'get',
                dataType: "json",
                beforeSend: function() {
                    $('#order_list_loder').show();
                },
                success: function(data) {
                    $('#order_list_loder').hide();
                    var my_array;
                    my_array = [];
                    for (var i = 0; i < data.length; i++) {
                        var this_id = data[i].status_id;
                        var this_date = new Date(data[i].date);
                        this_date = this_date.getFullYear() + "-" + "0" + (this_date.getMonth() + 1) +
                            "-" +
                            ("0" + this_date.getDate()).slice(-2)
                        if ((this_id == $select_id)) {
                            my_array.push(data[i]);
                        }
                        console.log(this_id == $select_id);
                    }
                    $("#table").bootstrapTable("load", my_array);
                },
                error: function(error) {
                    $('#order_list_loder').hide();
                    console.log(error);
                }
            })
        })




        $('#dateFrom,#dateTo').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxYear: parseInt(moment().format('YYYY'), 10),
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
        $("#getJsonSrc").click(function() {
            var $table = $("#table"),
                $startDate = $("#dateFrom").val(),
                $endDate = $("#dateTo").val(),
                $select_id = $('#order_status').val(),
                $jsonSrc = "{{ URL::signedRoute('admin.orders.create') }}";
            $.ajax({
                url: $jsonSrc,
                type: 'get',
                dataType: "json",
                beforeSend: function() {
                    $('#order_list_loder').show();
                },
                success: function(data) {
                    $('#order_list_loder').hide();
                    var my_array;
                    my_array = [];
                    for (var i = 0; i < data.length; i++) {
                        var this_id = data[i].status_id;
                        var this_date = new Date(data[i].date);
                        this_date = this_date.getFullYear() + "-" + "0" + (this_date.getMonth() + 1) +
                            "-" +
                            ("0" + this_date.getDate()).slice(-2)
                        if ((this_id == $select_id) || (this_date >= $startDate) && (this_date <=
                                $endDate)) {
                            my_array.push(data[i]);
                        }
                    }
                    $("#table").bootstrapTable("load", my_array);
                },
                error: function(error) {
                    $('#order_list_loder').hide();
                    console.log(error);
                }
            })
        });


        function showuOrders(params) {
            $.ajax({
                type: "GET",
                url: "{{ URL::signedRoute('admin.orders.create') }}",
                dataType: "json",
                success: function(data) {
                    params.success(data)
                },
                error: function(er) {
                    params.error(er);
                }
            });
        }

        function order_amount(data) {
            return "$" + data;
        }

        function discount_amount(data) {
            return "$" + data;
        }

        function shipping_charge(data) {
            return "$" + data;
        }

        function total(data) {
            return '$' + data;
        }

        function payment_status(data) {
            if (data == 1) {
                return ["<a class='btn btn-soft-success ' href='#' title='Status'>",
                    "Paid",
                    "</a>"
                ].join('');
            } else {
                return ["<a class='btn btn-soft-danger ' href='#' title='Status'>",
                    "Unpaid",
                    "</a>"
                ].join('');
            }
        }

        // order status
        function ordersStatus(data) {
            if (data == 0) {
                return ["<a class='btn btn-soft-success ' href='#' title='Status'>",
                    "Self Pick",
                    "</a>"
                ].join('');
            }
            if (data == 1) {
                return ["<a class='btn btn-soft-warning ' href='#' title='Status'>",
                    "Processing",
                    "</a>"
                ].join('');
            } else if (data == 2) {
                return ["<a class='btn btn-soft-info ' href='#' title='Status'>",
                    "Order Placed",
                    "</a>"
                ].join('');
            } else if (data == 3) {
                return ["<a class='btn btn-soft-dark ' href='#' title='Status'>",
                    "In transit",
                    "</a>"
                ].join('');
            } else if (data == 4) {
                return ["<a class='btn btn-soft-primary ' href='#' title='Status'>",
                    "On The Way",
                    "</a>"
                ].join('');
            } else {
                return ["<a class='btn btn-soft-success ' href='#' title='Status'>",
                    "Delivered",
                    "</a>"
                ].join('');
            }
        }

        // action
        function ordersAction(value, row, index) {
            var order_details = "{{ route('admin.show_order_details', ':id') }}";
            order_details = order_details.replace(":id", row.id);

            var invoice_url = "{{ route('admin.invoice.show', ':id') }}"
            invoice_url = invoice_url.replace(":id", row.id);

            return [
                '<a class="btn btn-soft-info  btn-icon btn-circle btn-sm" href="' + order_details + '" title="Edit">',
                '<i class="fa fa-eye" aria-hidden="true"></i>',
                '</a>  ',
                '<a class="btn btn-soft-success  btn-icon btn-circle btn-sm" href="' + invoice_url +
                '" title="Download">',
                '<i class="las la-download"></i>',
                '<a class="btn btn-soft-danger  btn-icon btn-circle btn-sm" href="javascript:void(0)" title="Delete" onclick="deleteOrder(' +
                row.id + ')">',
                '<i class="las la-trash"></i>',
                '</a>'
            ].join('')
        }


        // delete order
        function deleteOrder(id) {
            $('#order_delete-modal').modal('show');
            $("#order_delete-link").attr("href", id);
        }
        // delete logic
        $('#order_delete-link').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ URL::signedRoute('admin.delete_order') }}",
                type: "post",
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: $(this).attr('href')
                },
                beforeSend: function() {
                    $('#order_list_loder').show()
                },
                success: function(data) {
                    $('#order_list_loder').hide()
                    $('#table').bootstrapTable('refresh')
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
                        $('#order_delete-modal').modal('hide');
                    }
                },
                error: function(error) {
                    $('#order_list_loder').hide()
                    console.log(error)
                }
            })
        });
    </script>
@endsection
@endsection
