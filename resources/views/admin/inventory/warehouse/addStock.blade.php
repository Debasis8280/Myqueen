<style>
    .form-group.required .control-label:after {
        content: "*";
        color: red;
    }

</style>
<table id="table_add_stock" data-toggle="table" data-height="460" data-ajax="ajaxRequest" data-pagination="true"
    data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-search="true"
    data-show-export="true">
    <thead>
        <tr>
            <th data-checkbox="true"></th>
            <th data-field="id">ID</th>
            <th data-field="productimagee" data-formatter="imageFormatter">Products Image</th>
            <th data-field="title">Products Name</th>
            <th data-field="wname" data-editable="true">Warehouse Name</th>
            <th data-field="rname" data-editable="true">Rack Name</th>
            <th data-field="stock" data-editable="true">Stock</th>
            <th data-field="operate" data-formatter="operateFormatter">Action</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

{{-- add warehouse stock --}}
<div class="modal fade" id="add_warehouse_stock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Warehouse Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="add_warehouse_stock_form">
                    @csrf
                    <div class="form-group required">
                        <label for="" class="control-label">Select Product:</label>
                        <select name="productid" id="select_warehouse_stock_product" class="form-control">
                            <option value="">--Select--</option>
                        </select>

                        <span id="add_warehouse_stock_product_name_error" style="color: red"></span>
                    </div>
                    <div class="form-group required">
                        <label for="" class="control-label">Select Warehouse:</label>
                        <select name="warehouseid" id="select_warehouse_stock_warehouse" class="form-control">
                            <option value="">--Select--</option>
                        </select>

                        <span id="add_warehouse_stock_name_error" style="color: red"></span>
                    </div>
                    <div class="form-group required">
                        <label for="" class="control-label">Select Rack:</label>
                        <select name="rackid" id="select_warehouse_stock_rack" class="form-control">
                            <option value="">--Select--</option>
                        </select>

                        <span id="add_warehouse_stock_rack_name_error" style="color: red"></span>
                    </div>
                    <div class="form-group required">
                        <label for="" class="control-label">Quantity:</label>
                        <input type="text" type="text" name="stock" class="form-control">

                        <span id="add_warehouse_stock_quantity_error" style="color: red"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="add_warehouse_stock_btn"><i
                        class="loading-icon fa fa-spinner fa-spin" id="add_warehouse_stock_spin" style="display: none">
                    </i>Save</button>
            </div>
        </div>
    </div>
</div>
{{-- end warehouse stock --}}

{{-- edit warehouse stock --}}
<div class="modal fade" id="edit_warehouse_stock_modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="edit_warehouse_stock_form">
                    @csrf
                    <div class="form-group required">
                        <label for="" class="control-label">Select Product:</label>
                        <input type="text" name="productname" class="form-control" readonly id="productname">
                        <input type="hidden" name="id" class="form-control" readonly id="id">

                        <span id="edit_warehouse_stock_product_name_error" style="color: red"></span>
                    </div>
                    <div class="form-group required">
                        <label for="" class="control-label">Select Warehouse:</label>
                        <select name="warehouseid" id="select_edit_warehouse_stock_warehouse" class="form-control">
                            <option value="">--Select--</option>
                        </select>

                        <span id="edit_warehouse_stock_name_error" style="color: red"></span>
                    </div>
                    <div class="form-group required">
                        <label for="" class="control-label">Select Rack:</label>
                        <select name="rackid" id="select_edit_warehouse_stock_rack" class="form-control">
                            <option value="">--Select--</option>
                        </select>

                        <span id="edit_warehouse_stock_rack_name_error" style="color: red"></span>
                    </div>
                    <div class="form-group required">
                        <label for="" class="control-label">Quantity:</label>
                        <input type="text" name="stock" class="form-control" id="stock">

                        <span id="edit_edit_warehouse_stock_quantity_error" style="color: red"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="edit_stock_btn"><i
                        class="loading-icon fa fa-spinner fa-spin" id="edit_stock_spin" style="display: none">
                    </i>Save</button>
            </div>
        </div>
    </div>
</div>
@include('admin.modal.index')
{{-- end edit warehouse stock --}}

<div id="warehouse_add_stock_loder" style="display: none">
    @include('admin.loder.index');
</div>
