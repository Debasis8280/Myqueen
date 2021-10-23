@extends('admin.layout.main')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#add_warehouse" role="tab"
                        aria-controls="home" aria-selected="true">Add Warehouse</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="warehouse_management-tab" data-toggle="tab" href="#warehouse_management"
                        role="tab" aria-controls="profile" aria-selected="false">Warehouse Management</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="Return-tab" data-toggle="tab" href="#return" role="tab"
                        aria-controls="contact" aria-selected="false">Return</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="category-tab" data-toggle="tab" href="#category" role="tab"
                        aria-controls="category" aria-selected="false">Category</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="forcast-tab" data-toggle="tab" href="#forcast" role="tab"
                        aria-controls="forcast" aria-selected="false">Inventory Forcast</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="product-tab" data-toggle="tab" href="#product" role="tab"
                        aria-controls="product" aria-selected="false">Products</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="branches-tab" data-toggle="tab" href="#branches" role="tab"
                        aria-controls="branches" aria-selected="false">Branches</a>
                </li>
            </ul>
            <div class="tab-content bg-white" id="myTabContent">
                <div class="tab-pane fade show active" id="add_warehouse" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <div class="p-1">
                            <button type="button" class="btn btn-info add-new" data-toggle="modal"
                                data-target="#add_warehouse_modal" onclick="add_ware_house()"><i class="fa fa-plus"></i>
                                Add
                                Warehouse</button>
                        </div>
                        <div class="p-1">
                            <button type="button" class="btn btn-info add-new" data-toggle="modal"
                                data-target="#add_rack_modal" onclick="addRack()"><i class="fa fa-plus"></i> Add
                                Rack</button>
                        </div>
                    </div>
                    @include('admin.inventory.warehouse.index')
                </div>
                <div class="tab-pane fade" id="warehouse_management" role="tabpanel"
                    aria-labelledby="warehouse_management-tab">
                    <div class="row">
                        <div class="p-1">
                            <button type="button" class="btn btn-info add-new" data-toggle="modal"
                                data-target="#add_warehouse_stock" onclick="getData()"><i class="fa fa-plus"></i> Add
                                Stock</button>
                        </div>
                    </div>
                    @include('admin.inventory.warehouse.addStock')
                </div>
                <div class="tab-pane fade" id="return" role="tabpanel" aria-labelledby="return-tab">
                    <div class="row">
                        <div class="p-1">
                            <button type="button" class="btn btn-info add-new" data-toggle="modal"
                                data-target="#add_return_modal" onclick="getReturnData()"><i class="fa fa-plus"></i> Add
                                Return</button>
                        </div>
                    </div>
                    @include('admin.inventory.return.index')
                </div>

                <div class="tab-pane fade" id="category" role="tabpanel" aria-labelledby="category-tab">
                    <div class="row">
                        <div class="p-1">
                            <button type="button" class="btn btn-info add-new" data-toggle="modal"
                                data-target="#add_category_modal" onclick="add_category()"><i class="fa fa-plus"></i>
                                Add
                                Category</button>
                        </div>
                    </div>
                    @include('admin.inventory.category.index')
                </div>


                <div class="tab-pane fade" id="forcast" role="tabpanel" aria-labelledby="forcast-tab">
                    @include('admin.inventory.inventoryforcast.index')
                </div>

                <div class="tab-pane fade" id="product" role="tabpanel" aria-labelledby="product-tab">
                    <div class="p-1">
                        <a class="btn btn-info add-new" href="{{ route('admin.product.create') }}"><i
                                class="fa fa-plus"></i> Add
                            Product</a>
                    </div>
                    @include('admin.inventory.product.index')
                </div>

                <div class="tab-pane fade" id="branches" role="tabpanel" aria-labelledby="product-tab">
                    <div class="p-1">
                        <button type="button" class="btn btn-info add-new" data-toggle="modal"
                            data-target="#add_branch_modal" onclick="add_branches()"><i class="fa fa-plus"></i> Add
                            Branches</button>
                    </div>
                    @include('admin.inventory.branch.index')
                </div>

            </div>
        </div>
    </div>


    {{-- loder --}}
    <div class="inventory_loder" style="display: none">
        @include('admin.loder.index')
    </div>
    {{-- end loder --}}



@section('javascript')
    @include('admin.inventory.js.warehousejs')
    @include('admin.inventory.js.addstockjs')
    @include('admin.inventory.js.returnjs')
    @include('admin.inventory.js.categoryjs')
    @include('admin.inventory.js.forcastjs')
    @include('admin.inventory.js.productlistjs')
    @include('admin.inventory.js.branchjs')
@endsection

@endsection
