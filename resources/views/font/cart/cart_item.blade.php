<style>
    .btn btn-primary{
        padding: 10px 15px !important;
    }
    .item-price{
        margin-top: 45px
    }
</style>
<div class="row mt-5">
    <div class="col-md-8" id="cart_product_list">
        {{-- <div class="card mycard">
            <div class="card-body p-4">

                <div class="row">
                    <div class="item-img col-md-5">
                        <a href="app-ecommerce-details.html">
                            <img src="{{ asset('product/product_imagee/product_imagee12_10_21_06_10Debasis.jpg') }}"
                                alt="img-placeholder" style="width: 200px; height: 100%;">
                        </a>
                    </div>
                    <div class="col-md-4">
                        <div class="item-name">
                            <h6 class="mb-0"><a href="app-ecommerce-details.html" class="text-body">Apple
                                    Watch Series
                                    511111111111111111111111111111111111111111111111111111111111111111111111111111</a>
                            </h6>
                        </div>

                        <div class="ratings-container">
                            <div class="ratings-full">
                                <span class="ratings" style="width:80%"></span>
                                <span class="tooltiptext tooltip-top"></span>
                            </div>
                            <a href="#review" class="link-to-tab rating-reviews" id="rating_count"></a>
                        </div>


                        <div class="item-quantity">
                            <span class="quantity-title">Qty:</span>
                            <input id="demo1" type="text" value="1" name="demo1">
                        </div>

                    </div>

                    <div class="item-options text-center col-md-3">
                        <div class="item-wrapper">
                            <div class="item-cost">
                                <h4 class="item-price">$19.99</h4>
                            </div>
                        </div>
                        <button type="button" class=" btn btn-primary float-right">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-x align-middle me-25">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                            <span>Remove</span>
                        </button>
                    </div>

                </div>

            </div>
        </div> --}}
    </div>
    <div class="col-md-4">
        <div class="card mycard">
            <div class="card-body">
                {{-- <label class="section-label form-label mb-1">Options</label> --}}
                <div class="row">
                    {{-- <div class="col-md-7">
                        <input type="text" class="form-control" placeholder="Coupons" aria-label="Coupons"
                            aria-describedby="input-coupons">
                    </div>
                    <div class="col-md-5">
                        <button class="btn btn-primary" id="input-coupons" style="padding: 11px;">Apply</button>
                    </div> --}}
                </div>
                <hr>
                <div class="price-details">
                    <h6 class="price-title">Price Details</h6>
                    <ul class="list-unstyled">
                        <li class="price-detail ">
                            <div class="detail-title">Total MRP</div>
                            <div class="detail-amt total_cart_amount"></div>
                        </li>
                    </ul>
                    <hr>
                    <ul class="list-unstyled">
                        <li class="price-detail">
                            <div class="detail-title detail-total">Total</div>
                            <div class="detail-amt fw-bolder total_cart_amount"></div>
                        </li>
                        <input type="hidden" name="cart_part" id="cart_part">
                    </ul>
                    <button type="button"
                        class="btnNext btn btn-primary w-100 btn-next place-order waves-effect waves-float waves-light"
                        id="place_order_btn">Place
                        Order</button>
                </div>
            </div>
        </div>
    </div>
</div>
