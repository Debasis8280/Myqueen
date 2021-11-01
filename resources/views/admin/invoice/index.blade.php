@php
$data = json_decode(json_encode($order_summary));
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $data->order_no }}</title>
    <style>
        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        span,
        div {
            font-family: DejaVu Sans;
            font-size: 10px;
            font-weight: normal;
        }

        th,
        td {
            font-family: DejaVu Sans;
            font-size: 10px;
        }

        .panel {
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid transparent;
            border-radius: 4px;
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .panel-default {
            border-color: #ddd;
        }

        .panel-body {
            padding: 15px;
        }

        table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 0px;
            border-spacing: 0;
            border-collapse: collapse;
            background-color: transparent;
        }

        thead {
            text-align: left;
            display: table-header-group;
            vertical-align: middle;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        .well {
            min-height: 20px;
            padding: 19px;
            margin-bottom: 20px;
            background-color: #f5f5f5;
            border: 1px solid #e3e3e3;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
        }

    </style>

    <style>
        @page {
            margin-top: 140px;
        }

        header {
            top: -100px;
            position: fixed;
        }

    </style>
</head>

<body>

    <header>
        <div style="position:absolute; left:0pt; ">
            <img class="img-rounded" src="{{ public_path('asset/image/logo.png') }}" height="50" width="200">
        </div>
        <div style="margin-left:300pt;">
            <b>Date: </b>{{ $data->order_date }}<br />

            <b>Invoice #: </b> {{ $data->order_no }}<br />

            <b>Payment: </b>
            @if ($data->payment_status == 1)
                <span style="color: #fff;background-color: #28a745;padding: 8pt;">Approve</span>
            @else
                <span style="color: #fff;background-color: red;padding: 8pt;">Pending</span>
            @endif
            <br />
            <b>Status: </b>
            @if ($data->status_id == 1)
                <span style="color: #fff;background-color: #28a745">Processing</span>
            @elseif($data->status_id == 2)
                <span style="color: #fff;background-color: darkblue">Order Placed
                </span>
            @elseif($data->status_id == 3)
                <span style="color: #fff;background-color: #9aa728">In transit</span>
            @elseif($data->status_id == 4)
                <span style="color: #fff;background-color: #2831a7">On The Way</span>
            @elseif($data->status_id == 5)
                <span style="color: #fff;background-color: #7828a7">Delivered</span>
            @elseif($data->status_id == 6)
                <span style="color: #fff;background-color: red">Cancelled</span>
            @else
                <span style="color: #fff;background-color: #28a745">Slef Pick</span>
                @if ($data->self_pick_order_status == 5)
                    <span style="color: #fff;background-color: #28a745;padding: 8pt;">Complete</span>
                @elseif($data->self_pick_order_status == 6)
                    <span style="color: #fff;background-color: red;padding: 8pt;">Cancelled</span>
                @endif
            @endif
        </div>
        <br />
        <h2>Invoice {{ $data->order_no ? '#' . $data->order_no : '' }}</h2>
    </header>
    <main>
        <div style="clear:both; position:relative;">
            <div style="position:absolute; left:0pt; width:250pt;">
                <h4>Billing Details:</h4>
                <div class="panel panel-default">
                    <div class="panel-body">
                        {{ $data->name }}<br>
                        {{ $data->email }}<br>
                        {{ $data->phone }}<br>
                        {{ $data->billing_address }}
                    </div>
                </div>
            </div>
            <div style="margin-left: 300pt;margin-top: 2pt;">
                <h4>Shipping Details:</h4>
                <div class="panel panel-default">
                    <div class="panel-body">
                        {{ $data->name }}<br>
                        {{ $data->email }}<br>
                        {{ $data->phone }}<br>
                        {{ $data->shipping_address }}
                    </div>
                </div>
            </div>
        </div>
        <h4>Items:</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Item Name</th>
                    <th>Shipping Method</th>
                    <th>Quentity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order_details as $key => $item)
                    <tr>
                        <td style="text-align: center">{{ $key + 1 }}</td>

                        <td style="text-align: center">
                            <img src="{{ public_path($item->image) }}" alt="" class="img-fluid" height="50">
                        </td>
                        <td style="text-align: center">
                            {{ $item->title }}
                        </td>
                        <td style="text-align: center">
                            {{ $item->shipping_method }}
                        </td>
                        <td style="text-align: center">
                            {{ $item->qun }}
                        </td>
                        <td style="text-align: center">
                            ${{ $item->saleprice * $item->qun }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="clear:both; position:relative;">

            {{-- <div style="position:absolute; left:0pt; width:250pt;">
                <h4>Notes:</h4>
                <div class="panel panel-default">
                    <div class="panel-body">
                        11
                    </div>
                </div>
            </div> --}}

            <div style="margin-left: 300pt;">
                <h4>Total:</h4>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td><b>Subtotal</b></td>
                            <td>${{ $data->sub_total }}
                            </td>
                        </tr>
                        <tr>
                            <td><b>Shipping</b></td>
                            <td>${{ $data->shipping_charge }}
                            </td>
                        </tr>
                        <tr>
                            <td><b>Subtotal</b></td>
                            <td>${{ $data->coupon_discount }}
                            </td>
                        </tr>
                        <tr>
                            <td><b>TOTAL</b></td>
                            <td><b>${{ $data->total_amount }}
                                </b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <br /><br />
        <div class="well">
            <h3>Thanks for shopping</h3>
        </div>
    </main>

</body>

</html>
