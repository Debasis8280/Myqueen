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
                return '<span class="badge badge-inline badge-success">Paid</span>';
            } else {
                return ' <span class="badge badge-inline badge-danger">Unpaid</span>';
            }
        }
    </script>
@endsection
