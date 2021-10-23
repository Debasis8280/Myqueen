<table id="product_table_list" data-toggle="table" data-height="460" data-ajax="showProduct" data-pagination="true"
    data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-search="true"
    data-show-export="true">
    <thead>
        <tr>
            <th data-checkbox="true"></th>
            <th data-field="id">ID</th>
            <th data-field="productimagee" data-formatter="productImage">Products Image</th>
            <th data-field="title">Products Name</th>
            <th data-field="categoryname">category</th>
            <th data-field="regularprice">Regular Price</th>
            <th data-field="saleprice">Sale Price</th>
            <th data-field="istock">Stock</th>
            <th data-field="status" data-formatter="product_status">Status</th>
            <th data-field="operate" data-formatter="productAction">Action</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
<div id="product_delete-modal" class="modal fade">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h6">Delete Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body text-center">
                <p class="mt-1">Are you sure to delete this?</p>
                <button type="button" class="btn btn-link mt-2" data-dismiss="modal">Cancel</button>
                <a href="" id="product_delete-link" class="btn btn-primary mt-2">Delete</a>
            </div>
        </div>
    </div>
</div>
