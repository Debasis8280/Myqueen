<style>
    .form-group.required .control-label:after {
        content: "*";
        color: red;
    }

</style>
<div class="table-responsive">
    <table id="table_top_up" data-toggle="table" data-height="460" data-ajax="show_top_up_list" data-pagination="true"
        data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-search="true"
        data-show-export="true">
        <thead>
            <tr>
                <th data-checkbox="true"></th>
                <th data-field="id">ID</th>
                <th data-field="name">Name</th>
                <th data-field="amount">Amount</th>
                <th data-field="screen_shot" data-formatter="payment_image">Image</th>
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
