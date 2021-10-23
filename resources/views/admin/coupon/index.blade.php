@extends('admin.layout.main')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="mb-2 row">
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Coupon </li>
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
                                <h3 class="card-title">Coupon</h3>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="table" data-toggle="table" data-height="460" data-ajax="showCoupons"
                                    data-pagination="true" data-show-columns="true" data-show-pagination-switch="true"
                                    data-show-refresh="true" data-search="true" data-show-export="true">
                                    <thead>
                                        <tr>
                                            <th data-checkbox="true"></th>
                                            <th data-field="id">ID</th>
                                            <th data-field="number">Number</th>
                                            <th data-field="discount_type">Discount Type</th>
                                            <th data-field="discount_number">Discount Amount</th>
                                            <th data-field="operate" data-formatter="couponAction">Action</th>

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
                                <form action="" method="POST" id="add_coupon_form">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">Generate Coupon</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="widget-content nopadding">
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2">Coupon</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="coupon_number" value=""
                                                        id="coupon_number" readonly>
                                                    <span style="color: red" id="coupon_number_error"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                    <label for="" class="control-label">Select Type</label>
                                                    <select name="coupon_select" id="coupon_select" class="form-control">
                                                        <option value="">select</option>
                                                        <option value="Fixed">Fixed</option>
                                                        <option value="Percentage">Percentage</option>
                                                    </select>
                                                    <span style="color: red" id="coupon_select_error"></span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="" class="control-label">Enter Number</label>
                                                    <input type="number" class="form-control" name="coupon_discount"
                                                        value="" id="coupon_discount">
                                                    <span style="color: red" id="coupon_discount_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="form-group">
                                            <button class="btn btn-primary" data-loading-text="Loading..."
                                                id="coupon_form_generate_btn" type="submit">
                                                <i class="loading-icon fa fa-spinner fa-spin" id="coupon_form_gene_btnspin"
                                                    style="display:none"></i>
                                                Generate
                                            </button>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary" data-loading-text="Loading..."
                                                id="coupon_form_save_btn" type="submit">
                                                <i class="loading-icon fa fa-spinner fa-spin" id="coupon_form_save_btnspin"
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

    <div id="coupon_loder" style="display: none">
        @include('admin.loder.index')
    </div>

@section('javascript')


    <script>
        // show coupon 
        function showCoupons(params) {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.coupon.create') }}",
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
        function couponAction(value, row, index) {
            return [
                '<a class="btn btn-soft-danger  btn-icon btn-circle btn-sm" href="javascript:void(0)" title="Delete" onclick="deleteCoupon(' +
                row.id + ')">',
                '<i class="las la-trash"></i>',
                '</a>'
            ].join('')
        }



        // generate coupon
        $('#coupon_form_generate_btn').click(function(e) {
            e.preventDefault();
            $('#coupon_form_gene_btnspin').show()
            var coupon = "MQCC" + Math.floor((Math.random() * 10000) + 5);
            $('#coupon_number').val(coupon)
            $('#coupon_form_gene_btnspin').hide()
        });


        // add coupon in database
        $('#coupon_form_save_btn').click(function(e) {
            e.preventDefault();
            var form = $('#add_coupon_form')[0];
            var data = new FormData(form);
            $.ajax({
                url: "{{ route('admin.coupon.store') }}",
                type: 'post',
                dataType: 'json',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('#coupon_form_save_btnspin').show();
                    $("#add_coupon_form :input").prop("disabled", true);
                },
                success: function(data) {
                    if (data.status == 'success') {
                        $('#coupon_form_save_btnspin').hide();
                        $("#add_coupon_form :input").prop("disabled", false);
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
                        $('#add_coupon_form')[0].reset();

                        $('#table').bootstrapTable('refresh');
                    }
                },
                error: function(error) {
                    $('#coupon_form_save_btnspin').hide();
                    $("#add_coupon_form :input").prop("disabled", false);
                    var err = error.responseJSON.errors;
                    if (error.status == 422) {
                        $('#coupon_number_error').html(err.coupon_number)
                        $('#coupon_select_error').html(err.coupon_select)
                        $('#coupon_discount_error').html(err.coupon_discount)
                    }
                }
            })
        });

        // clear error
        $('#coupon_number,#coupon_select,#coupon_discount').click(function() {
            $('#coupon_number_error').html('')
            $('#coupon_select_error').html('')
            $('#coupon_discount_error').html('')
        })

        // delete modal
        function deleteCoupon(id) {
            $("#delete-modal").modal("show");
            $("#delete-link").attr("href", id);
        }

        // delete logic
        $('#delete-link').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('admin.coupon.delete') }}",
                type: "post",
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: $(this).attr('href')
                },
                beforeSend: function() {
                    $('#coupon_loder').show();
                },
                success: function(data) {
                    $('#coupon_loder').hide();
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
                    $('#coupon_loder').hide();
                    console.log(error)
                }
            })
        });
    </script>
@endsection

@endsection
