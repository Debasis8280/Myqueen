@extends('font.layouts.main')
@section('content')
    <main class="main mt-6 single-product">
        <div class="page-content mb-10 pb-6">
            <div class="container">
                <div class="product product-single row mb-7">
                    <div class="col-md-6 sticky-sidebar-wrapper">
                        <div class="product-gallery pg-vertical sticky-sidebar" data-sticky-options="{'minWidth': 767}">
                            <div class="product-single-carousel owl-carousel owl-theme owl-nav-inner row cols-1"
                                id="product_image">

                            </div>
                            <div class="product-thumbs-wrap">
                                <div class="product-thumbs" id="product_thumbs">


                                </div>
                                <button class="thumb-up disabled"><i class="fas fa-chevron-left"></i></button>
                                <button class="thumb-down disabled"><i class="fas fa-chevron-right"></i></button>
                            </div>
                            <div class="product-label-group">
                                <label class="product-label label-new">new</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="product-details">
                            <div class="product-navigation">
                                <ul class="breadcrumb breadcrumb-lg">
                                    <li><a href="demo1.html"><i class="d-icon-home"></i></a></li>
                                    <li><a href="#" class="active">Products</a></li>
                                    <li>Detail</li>
                                </ul>


                            </div>

                            <h1 class="product-name" id="details_product_name"></h1>
                            <div class="product-meta">
                                <span class="product-sku">Singapore MY QUEEN brand
                                </span>

                            </div>
                            <div class="product-price" id="details_product_price"></div>
                            <div class="ratings-container">
                                <div class="ratings-full">
                                    <span class="ratings" style="width:80%"></span>
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                                <a href="#review" class="link-to-tab rating-reviews" id="rating_count"></a>
                            </div>
                            <p class="product-short-desc">1 Set = 1 Unit, 1 unit 30ml, Price: USD 88, PV88 (Credit) </p>



                            <hr class="product-divider">

                            <div class="product-form product-qty">
                                <div class="product-form-group">
                                    <div class="input-group mr-2">
                                        <a class="quantity-minus d-icon-minus" style="font-size: 28px;margin-top: 7px;"></a>
                                        <input class="quantity form-control" type="number" min="1" max="1000000"
                                            id="quentity">
                                        <a class="quantity-plus d-icon-plus" style="font-size: 28px;margin-top: 7px;"></a>
                                    </div>

                                    <button class="btn btn-primary" onclick="add_to_cart()">
                                        <i class="loading-icon fa fa-spinner fa-spin" id="add_cart_spin"
                                            style="display: none">
                                        </i>
                                        <i class="d-icon-bag" style="margin-top: -4px;padding: 4px;"></i> Add to
                                        Cart
                                    </button>
                                </div>
                            </div>

                            <hr class="product-divider mb-3">

                            <div class="product-footer">

                                <span class="divider d-lg-show"></span>
                                <a href="#" class="btn-product btn-wishlist mr-6"><i class="d-icon-heart"></i>Add to
                                    wishlist</a>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab tab-nav-simple product-tabs">
                    <ul class="nav nav-tabs justify-content-center" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#product-tab-description">Components</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#product-effect">Major Effects</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#product-method">Use Method</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#review">Review</a>
                        </li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active in" id="product-tab-description">
                            <div class="row mt-6">
                                <h5 class="description-title mb-4 font-weight-semi-bold ls-m">Main Components</h5>
                                <div class="col-md-6" id="main_desc">
                                    {{-- desc --}}
                                </div>
                                <div class="col-md-6">
                                    <img src="" class="img-fluid" alt="" id="main_desc_img">
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane" id="product-effect">
                            <h2>Major Effects
                            </h2>
                            <div class="row">
                                <div id="details_effect" class="col-md-6">

                                </div>
                                <div class="col-md-6">
                                    <img src="" class="img-fluid" alt="" id="details_effect_img">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane " id="product-method">

                            <h2>Use Method</h2>
                            <div class="row">
                                <div id="details_use_method" class="col-md-6">

                                </div>
                                <div class="col-md-6">
                                    <img src="" class="img-fluid" alt="" id="details_use_method_img">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane " id="review">
                            <div class="comments mb-8 pt-2 pb-2 border-no">
                                <ul id="show_rating_list">
                                    {{-- all rating --}}
                                </ul>
                            </div>
                            <div class="reply">
                                <div class="title-wrapper text-left">
                                    <h3 class="title title-simple text-left text-normal">Add a Review</h3>
                                </div>
                                <div class="rating-form">
                                    <label for="rating" class="text-dark">Your rating * </label>
                                    <span class="rating-stars selected">
                                        <a class="star-1 r" onclick="reviewPoint(1)" id="r1">1</a>
                                        <a class="star-2 r" onclick="reviewPoint(2)" id="r2">2</a>
                                        <a class="star-3 r" onclick="reviewPoint(3)" id="r3">3</a>
                                        <a class="star-4 r" onclick="reviewPoint(4)" id="r4">4</a>
                                        <a class="star-5 r" onclick="reviewPoint(5)" id="r5">5</a>
                                    </span>
                                </div>
                                <form action="#" id="rating_form">
                                    @csrf
                                    <input type="hidden" name="rating_point" id="reviewValue" value="0">
                                    <input type="hidden" name="product_id" value="{{ request()->id }}">
                                    <textarea id="reply-message" cols="30" rows="6" class="form-control mb-4"
                                        placeholder="Comment *" name="message"></textarea>
                                    <span style="color: red" id="rating_message_error"></span>
                                    <br>
                                    <button type="submit" class="btn btn-dark btn-rounded" id="rating_btn">
                                        <i class="loading-icon fa fa-spinner fa-spin" id="rating_spin"
                                            style="display: none">
                                        </i>
                                        Submit
                                        <i class="d-icon-arrow-right"></i>
                                    </button>
                                </form>
                            </div>
                            <!-- End Comments -->

                            <!-- End Reply -->
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </main>
@section('javascript')
    @include('font.js.product_detailsjs')
@endsection
@endsection
