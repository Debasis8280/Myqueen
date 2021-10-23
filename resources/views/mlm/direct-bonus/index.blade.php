@extends('mlm.layouts.main')
@section('content')
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

        .aiz-table thead th {
            border-top: 0;
            border-bottom: 1px solid #eceff7;
        }

        .aiz-table th {
            padding: 1rem 0.75rem;
        }

        .aiz-table td,
        .aiz-table th {
            padding: 1rem 0.75rem;
        }

    </style>
    <link rel="stylesheet" href="{{ asset('asset/table/bootstrap-table.min.css') }}">
    <main class="main mt-6 single-product">
        <div class="page-content mb-10 pb-6">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Direct Bonus History</h5>
                    </div>
                    <div class="card-body">
                        <table id="table" data-toggle="table" data-height="460" data-ajax="show_matching"
                            data-pagination="true" data-show-refresh="true" data-search="true" data-show-footer="true">
                            <thead>
                                <tr>
                                    <th data-checkbox="true" data-footer-formatter="total"></th>
                                    <th data-field="sponsors_id">Sponser Id</th>
                                    <th data-field="member_id">Member Id
                                    </th>
                                    <th data-field="member_name">Member Name</th>
                                    <th data-field="point" data-formatter="usd" data-footer-formatter="priceFormatter">USD
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="loder" style="display: none">
        @include('mlm.loder.index')
    </div>

@section('javascript')
    <script src="{{ asset('asset/table/bootstrap-table.min.js') }}"></script>
    <script>
        function show_matching(params) {
            $.ajax({
                type: "GET",
                url: "{{ URL::signedRoute('MLM.direct_bonus.create') }}",
                dataType: "json",
                success: function(data) {
                    console.log(data)
                    params.success(data)
                },
                error: function(er) {
                    params.error(er);
                }
            });
        }

        function usd(data) {
            return "$" + data;
        }

        function total() {
            return 'Total';
        }

        function priceFormatter(data) {
            var field = this.field
            console.log(data)
            return '$' + data.map(function(row) {
                return +row[field]
            }).reduce(function(sum, i) {
                return sum + i
            }, 0)
        }
    </script>
@endsection

@endsection
