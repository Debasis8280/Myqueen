<style>
    .form-group.required .control-label:after {
        content: "*";
        color: red;
    }

</style>
<div class="table-responsive">
    <table id="table" data-toggle="table" data-height="460" data-ajax="show_mct_pay" data-pagination="true"
        data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-search="true"
        data-show-export="true">
        <thead>
            <tr>
                <th data-checkbox="true"></th>
                <th data-field="id">ID</th>
                <th data-field="name">User Name</th>
                <th data-field="total">Pay</th>
                <th data-field="status" data-formatter="mct_payment_status">Status</th>
                <th data-field="operate" data-formatter="show_mct_pay_action">Action</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
