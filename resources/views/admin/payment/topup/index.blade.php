<style>
    .form-group.required .control-label:after {
        content: "*";
        color: red;
    }

</style>
<link rel="stylesheet" href="{{ asset('public/css/mycss.css') }}">
<div class="table-responsive">
    <table id="table_top_up" data-toggle="table" data-height="460" data-ajax="show_top_up_list" data-pagination="true"
        data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-search="true"
        data-show-export="true">
        <thead>
            <tr>
                <th data-checkbox="true"></th>
                <th data-field="ID">ID</th>
                <th data-field="firstname">Name</th>
                <th data-field="amount">Amount</th>
                <th data-field="payment_image" data-formatter="payment_image">Image</th>
                <th data-field="status" data-formatter="top_up_status">Status</th>
                <th data-field="operate" data-formatter="top_up_action">Action</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
{{-- show details --}}
<div class="modal fade" id="show_top_up_details_modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Top Up Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="id" id="top_up_details_id">
                    @include('admin.payment.topup.showDetails')
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="top_up_approve_btn">
                    <i class="loading-icon fa fa-spinner fa-spin" id="top_up_approve_spin" style="display: none"></i>
                    Approve
                </button>
            </div>
        </div>
    </div>
</div>
{{-- end details --}}
<div id="category_delete-modal" class="modal fade">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h6">Delete Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body text-center">
                <p class="mt-1">Are you sure to delete this?</p>
                <button type="button" class="btn btn-link mt-2" data-dismiss="modal">Cancel</button>
                <a href="" id="category_delete-link" class="btn btn-primary mt-2">Delete</a>
            </div>
        </div>
    </div>
</div>

<div id="big_loder" style="display: none">
    @include('admin.loder.index')
</div>

<script>
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
            url: "{{ route('admin.top_up.index') }}",
            dataType: "json",
            success: function(data) {
                // console.log(data);
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
            row.ID + ')">',
            '<i class="fa fa-eye" aria-hidden="true"></i>',
            '</a>'
        ].join('')
    }

    // image
    function payment_image(data) {
        var url = "{{ asset('') }}";
        return "<img src='" + url + data + "' width='100'>"
    }

    // show payment details
    function show_top_up_model(id) {
        $('#show_top_up_details_modal').modal('show');
        $.ajax({
            url: "{{ route('admin.top_up.create') }}",
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
                $('#top_up_details_id').val(data.ID);
                $('#top_up_payment_image_details').attr('src', url + data.payment_image);
                $('#top_up_amount_details').html("$" + data.amount);
                $('#top_up_name_details').html(data.firstname);
                $('#top_up_email_details').html(data.email);
                $('#top_up_phone_details').html(data.phone);
                $('#top_up_payment_date').html(data.date);

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
            url: "{{ route('admin.top_up.store') }}",
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
</script>
