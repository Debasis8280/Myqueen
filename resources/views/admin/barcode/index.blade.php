@extends('admin.layout.main')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="generate-tab" data-toggle="tab" href="#generate" role="tab"
                        aria-controls="generate" aria-selected="true">Generate Barcode</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="warehouse_management-tab" data-toggle="tab" href="#scan_barcode" role="tab"
                        aria-controls="profile" aria-selected="false">Scan Barcode</a>
                </li>
            </ul>
            <div class="tab-content bg-white" id="myTabContent">
                <div class="tab-pane fade show active" id="generate" role="tabpanel" aria-labelledby="generate-tab">
                    @include('admin.barcode.generate')
                </div>

                <div class="tab-pane fade" id="scan_barcode" role="tabpanel" aria-labelledby="scan_barcode-tab">
                    Scan Barcode
                </div>
            </div>
        </div>
    </div>
@endsection
