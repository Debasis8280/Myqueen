<div class="row">
    <div class="col-md-7">
        <input type="text" class="form-control" placeholder="Coupons" id="apply_coupon" name="apply_coupon">
    </div>
    <div class="col-md-5">
        <button class="btn btn-primary" id="apply_coupon_btn" style="padding: 11px;">Apply</button>
    </div>
</div>
<div class="row p-2">
    <div class="col-md-6">
        <div class="mb-6 form-checkbox shcheck" style="display: flex;align-items: center">
            <input type="checkbox" class="" id="mct_pay" name="mct_pay">
            <input type="hidden" name="payment_method" id="payment_method">
            <label class="form-control-label ls-s mt-1 p-2" for="different-address" id="shiptosame">
                MCT Pay
            </label>
        </div>
    </div>
    <div class="col-md-6" id="mct_pay_option" style="display: none">
        <img src="" alt="" id="mct_pay_qrcode_image" class="img-fluid">
    </div>
</div>

<div class="row p-2">
    <div class="col-md-6">
        <div class="mb-6 form-checkbox shcheck" style="display: flex;align-items: center">
            <input type="checkbox" class="" id="offline_pay" name="offline_pay">
            <label class="form-control-label ls-s mt-1 p-2" for="different-address" id="shiptosame">
                Offline Pay
            </label>
        </div>
    </div>
    <div class="col-md-6" id="offline_pay_option" style="display: none">
        <img src="{{ asset('payment_qr_code/paynow.jpeg') }}" alt="" id="offline_pay_qrcode_image"
            class="img-fluid">
        <input type="file" name="offline_pay_screen_shot" class="form-control">
    </div>
</div>
