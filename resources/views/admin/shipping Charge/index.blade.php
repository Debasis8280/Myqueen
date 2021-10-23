@extends('admin.layout.main')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="mb-2 row">
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Shipping Charge </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Shipping Charge</h3>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="table" data-toggle="table" data-height="460" data-ajax="showShippingCharge"
                                    data-pagination="true" data-show-columns="true" data-show-pagination-switch="true"
                                    data-show-refresh="true" data-search="true" data-show-export="true">
                                    <thead>
                                        <tr>
                                            <th data-checkbox="true"></th>
                                            <th data-field="id">ID</th>
                                            <th data-field="country">Country</th>
                                            <th data-field="amount">Amount</th>
                                            <th data-field="operate" data-formatter="shippingChargeAction">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="card">
                            <div class="widget-box">
                                <form action="" method="POST" id="add_shipc_form">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Shipping Amount</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="widget-content nopadding">
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2">Country</label>
                                                <div class="col-sm-9">
                                                    <select name="select_country" id="select_country"
                                                        class="form-control allcountry">
                                                        <option value="">Select</option>
                                                    </select>
                                                    <span style="color: red" id="select_country_error"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="" class="control-label">Enter Amount</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" name="amount" value=""
                                                        id="amount">
                                                    <span style="color: red" id="amount_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="form-group">
                                            <button class="btn btn-primary" data-loading-text="Loading..."
                                                id="ship_form_save_btn" type="submit">
                                                <i class="loading-icon fa fa-spinner fa-spin" id="ship_form_save_btnspin"
                                                    style="display:none"></i>
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- delete Modal -->
    <div id="delete-modal" class="modal fade">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">Delete Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mt-1">Are you sure to delete this?</p>
                    <button type="button" class="btn btn-link mt-2" data-dismiss="modal">Cancel</button>
                    <a href="" id="delete-link" class="btn btn-primary mt-2">Delete</a>
                </div>
            </div>
        </div>
    </div><!-- /.modal -->

    <div id="ship_charge_loder" style="display: none">
        @include('admin.loder.index');
    </div>

@section('javascript')


    <script>
        // show coupon 
        function showShippingCharge(params) {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.shipc.create') }}",
                dataType: "json",
                success: function(data) {
                    params.success(data)
                },
                error: function(er) {
                    params.error(er);
                }
            });
        }
        // action
        function shippingChargeAction(value, row, index) {
            return [
                '<a class="btn btn-soft-danger  btn-icon btn-circle btn-sm" href="javascript:void(0)" title="Delete" onclick="deleteShippingCharge(' +
                row.id + ')">',
                '<i class="las la-trash"></i>',
                '</a>'
            ].join('')
        }



        // get all country
        function getAllcountry() {
            $.ajax({
                url: "{{ route('get_all_country') }}",
                type: 'get',
                dataType: 'json',
                beforeSend: function() {
                    $('#ship_charge_loder').show()
                },
                success: function(data) {
                    $('#ship_charge_loder').hide()
                    var len = data.length;
                    for (var i = 0; i < len; i++) {
                        ''
                        $(".allcountry").append("<option value='" + data[i] + "'>" + data[i] +
                            "</option>");
                    }

                }
            })
        }

        $(document).ready(function() {
            getAllcountry();
        });


        // add coupon in database
        $('#ship_form_save_btn').click(function(e) {
            e.preventDefault();
            var form = $('#add_shipc_form')[0];
            var data = new FormData(form);
            $.ajax({
                url: "{{ route('admin.shipc.store') }}",
                type: 'post',
                dataType: 'json',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('#ship_form_save_btnspin').show();
                    $("#add_shipc_form :input").prop("disabled", true);
                },
                success: function(data) {
                    $('#ship_form_save_btnspin').hide();
                    $("#add_shipc_form :input").prop("disabled", false);
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
                        $('#add_shipc_form')[0].reset();
                        $('#table').bootstrapTable('refresh');
                    }
                },
                error: function(error) {
                    $('#ship_form_save_btnspin').hide();
                    $("#add_shipc_form :input").prop("disabled", false);
                    var err = error.responseJSON.errors;
                    if (error.status == 422) {
                        $('#select_country_error').html(err.select_country)
                        $('#amount_error').html(err.amount)
                    }
                }
            })
        });

        // clear error
        $('#select_country,#amount').click(function() {
            $('#select_country_error').html('')
            $('#amount_error').html('')
        })


        // delete modal
        function deleteShippingCharge(id) {
            $("#delete-modal").modal("show");
            $("#delete-link").attr("href", id);
        }

        // delete logic
        $('#delete-link').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('admin.shipc.delete') }}",
                type: "post",
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: $(this).attr('href')
                },
                beforeSend: function() {
                    $('#ship_charge_loder').show();
                },
                success: function(data) {
                    $('#ship_charge_loder').hide();
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
                        $('#delete-modal').modal('hide');
                        $('#table').bootstrapTable('refresh');
                    }
                },
                error: function(error) {
                    $('#ship_charge_loder').hide();
                    console.log(error)
                }
            })
        });
    </script>

@endsection

@endsection
