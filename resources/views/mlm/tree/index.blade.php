@extends('mlm.layouts.main')
@section('content')
    <div style="width:100%; height:700px;" id="orgchart">
    </div>

    <div id="loder" style="display: none">
        @include('mlm.loder.index');
    </div>
@section('javascript')
    <script src="{{ asset('asset/tree/orgchart.js') }}"></script>
    <script>
        var chart = new OrgChart(document.getElementById("orgchart"), {
            nodeBinding: {
                field_0: "name",
                field_1: "title",
                img_0: "img"
            },
            template: "isla",
            mouseScrool: OrgChart.action.scroll,
            menu: {
                pdf: {
                    text: "Export PDF"
                },
                png: {
                    text: "Export PNG"
                },
                svg: {
                    text: "Export SVG"
                },
                csv: {
                    text: "Export CSV"
                }
            },
            nodeMenu: {
                pdf: {
                    text: "Export PDF"
                },
                png: {
                    text: "Export PNG"
                },
                svg: {
                    text: "Export SVG"
                }
            },
            tags: {
                "0": {
                    left: 0
                },
                "1": {
                    right: 1
                },
            },

        });

        $(document).ready(function() {
            $.ajax({
                url: "{{ URL::signedRoute('MLM.tree.create') }}",
                type: 'get',
                dataType: 'json',
                beforeSend: function() {
                    $('#loder').show()
                },
                success: function(data) {
                    chart.load(data)
                    $('#loder').hide()
                }
            })
        })
    </script>
@endsection
@endsection
