<style>
    .form-group.required .control-label:after {
        content: "*";
        color: red;
    }

</style>
<div class="table-responsive">
    <table id="table" data-toggle="table" data-height="460" data-ajax="showQrCodePayment" data-pagination="true"
        data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-search="true"
        data-show-export="true">
        <thead>
            <tr>
                <th data-checkbox="true"></th>
                <th data-field="id">ID</th>
                <th data-field="screen_shot" data-formatter="qrCodeImage">Image</th>
                <th data-field="name">User Name</th>
                <th data-field="total">Pay</th>
                <th data-field="status" data-formatter="table_payment_status">Status</th>
                <th data-field="operate" data-formatter="QrCodePaymentAction">Action</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

{{-- end show Details --}}

@section('javascript')


    <script>
        function showQrCodePayment(params) {
            $.ajax({
                type: "GET",
                url: "{{ URL::signedRoute('admin.payment.create') }}",
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
        function QrCodePaymentAction(value, row, index) {
            var show_details = "{{ route('admin.payment.show_details', ':id') }}";
            show_details = show_details.replace(':id', row.id);
            return [
                '<a class="btn btn-soft-info  btn-icon btn-circle btn-sm" href="' + show_details + '" title="Delete" >',
                '<i class="fa fa-eye" aria-hidden="true"></i>',
                '</a>'
            ].join('')
        }

        // image
        function qrCodeImage(data) {
            var url = "{{ asset('') }}";
            return "<img src='" + url + data + "' style='width:100px'>"
        }

        function table_payment_status(data) {
            if (data == 1) {
                return '<span class="badge badge-inline badge-success">Approve</span>';
            } else {
                return ' <span class="badge badge-inline badge-danger">Pending</span>';
            }
        }


        function top_up_status(data) {
            if (data == 0) {
                return ["<a class='btn btn-soft-warning ' href='#' title='Status'>",
                    "Pending",
                    "</a>"
                ].join('');
            } else {
                return ["<a class='btn btn-soft-success ' href='#' title='Status'>",
                    "Approve",
                    "</a>"
                ].join('');
            }
        }

        function show_top_up_list(params) {
            $.ajax({
                type: "GET",
                url: "{{ URL::signedRoute('admin.wallet.index') }}",
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    params.success(data)
                },
                error: function(er) {
                    params.error(er);
                }
            });
        }

        // action
        function top_up_action(value, row, index) {
            return [
                '<a class="btn btn-soft-info  btn-icon btn-circle btn-sm" href="javascript:void(0)" title="Delete" onclick="show_top_up_model(' +
                row.id + ')">',
                '<i class="fa fa-eye" aria-hidden="true"></i>',
                '</a>'
            ].join('')
        }

        // image
        function payment_image(data) {
            var url = "{{ asset('') }}";

            return data != null ? "<img src='" + url + data + "' width='100'>" : '--';
        }

        // show payment details
        function show_top_up_model(id) {
            $('#show_top_up_details_modal').modal('show');
            $.ajax({
                url: "{{ route('admin.wallet.show_details') }}",
                type: 'get',
                data: {
                    id: id
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#big_loder').show();
                },
                success: function(data) {
                    $('#big_loder').hide();
                    var url = "{{ asset('') }}";
                    $('#top_up_details_id').val(data.id);
                    $('#top_up_payment_image_details').attr('src', url + data.screen_shot);
                    $('#top_up_amount_details').html("$" + data.amount);
                    $('#top_up_name_details').html(data.name);
                    $('#top_up_email_details').html(data.email);
                    $('#top_up_phone_details').html(data.phone);
                    $('#top_up_payment_date').html(data.created_at);

                },
                error: function(error) {
                    console.log(error)
                }
            })
        }

        // approve payment
        $('#top_up_approve_btn').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ URL::signedRoute('admin.wallet.store') }}",
                data: {
                    id: $('#top_up_details_id').val(),
                    "_token": "{{ csrf_token() }}"
                },
                type: 'post',
                dataType: 'json',
                beforeSend: function() {
                    $('#top_up_approve_spin').show()
                    $('#top_up_approve_btn').css('cursor', 'not-allowed')
                },
                success: function(data) {
                    $('#top_up_approve_spin').hide()
                    $('#top_up_approve_btn').css('cursor', '')
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
                    $('#table_top_up').bootstrapTable('refresh');
                },
                error: function(error) {
                    $('#top_up_approve_spin').hide()
                    $('#top_up_approve_btn').css('cursor', '')
                    console.log(error)
                }
            })
        })




        function show_mct_pay(params) {
            $.ajax({
                type: "GET",
                url: "{{ URL::signedRoute('admin.mct.create') }}",
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
        function show_mct_pay_action(value, row, index) {
            var show_details = "{{ route('admin.mct.show', ':id') }}";
            show_details = show_details.replace(':id', row.id);
            return [
                '<a class="btn btn-soft-info  btn-icon btn-circle btn-sm" href="' + show_details + '" title="Delete" >',
                '<i class="fa fa-eye" aria-hidden="true"></i>',
                '</a>'
            ].join('')
        }


        function mct_payment_status(data) {
            if (data == 1) {
                return '<span class="badge badge-inline badge-success">Approve</span>';
            } else {
                return ' <span class="badge badge-inline badge-danger">Pending</span>';
            }
        }
    </script>
@endsection
