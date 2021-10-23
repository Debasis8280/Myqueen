<style>
    .form-group.required .control-label:after {
        content: "*";
        color: red;
    }

</style>
<div class="table-responsive">
    <table id="table" data-toggle="table" data-height="460" data-ajax="showBarcode" data-pagination="true"
        data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-search="true"
        data-show-export="true">
        <thead>
            <tr>
                <th data-checkbox="true"></th>
                <th data-field="id">ID</th>
                <th data-field="productimagee" data-formatter="barcodeImage">Image</th>
                <th data-field="title">Name</th>
                <th data-field="id" data-formatter="barcode_Image">Barcode</th>
                <th data-field="id" data-formatter="downloadBarcode">Action</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<div id="loder" style="display: none">
    @include('admin.loder.index')
</div>


@section('javascript')

    <script>
        function showBarcode(params) {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.barcode.barcodeList') }}",
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
        function barcodeAction(value, row, index) {
            return [
                '<a class="btn btn-soft-info  btn-icon btn-circle btn-sm" href="javascript:void(0)" title="Edit" onclick="downloadBarcode(' +
                row.id + ')">',
                '<i class="fa fa-download" aria-hidden="true"></i>',
                '</a>  ',
            ].join('')
        }

        // image 
        function barcodeImage(data) {
            var url = "{{ asset('') }}";
            return "<img src='" + url + data + "' width='100'>"
        }

        // image
        function barcode_Image(data) {
            var img = '';
            $.ajax({
                async: false,
                url: "{{ route('admin.barcode.barcodeImage') }}",
                type: 'get',
                data: {
                    id: data
                },
                success: function(data) {
                    console.log(data)
                    img = data;
                },
                error: function(error) {

                }
            })
            return img;
        }

        // download barcode
        function downloadBarcode(data) {
            var img = '';
            var name = ''
            $.ajax({
                async: false,
                url: "{{ route('admin.barcode.download') }}",
                type: 'get',
                data: {
                    id: data
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#loder').show()
                },
                success: function(data) {
                    console.log(data)
                    img = data.img;
                    name = data.name;
                    $('#loder').hide()
                },
                error: function(error) {

                }
            })
            return "<a href=" + img + " download=" + name +
                "><i class='fa fa-download' aria-hidden='true'></i></a>";

        }
    </script>

@endsection
