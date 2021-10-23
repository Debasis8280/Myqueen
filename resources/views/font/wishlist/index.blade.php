@extends('font.layouts.main')
@section('content')
    <link rel="stylesheet" href="{{ asset('asset/css/font/productlist.css') }}">

    <style>
        .fixed-table-toolbar {
            float: right;
        }


        .pagination-detail {
            display: none;
        }

    </style>

    <main class="main">
        <div class="page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="breadcrumb-nav">
                            <div class="container">
                                <ul class="breadcrumb" style="background: none;">
                                    <li><a href="demo1.html"><i class="d-icon-home"></i></a></li>
                                    <li>Wishlist</li>
                                </ul>
                            </div>
                        </nav>
                        <div class="page-header pl-4 pr-4"
                            style="background-image: url({{ asset('asset/image/font/about-us.jpg') }})">

                            <h1 class="page-title font-weight-bold lh-1 text-capitalize" style="color: black">Wishlist</h1>

                        </div><!-- End .toolbox -->


                        <!-- test -->
                        <table id="table" data-search="true" data-pagination="true" data-page-size="6"
                            data-show-custom-view="true" data-custom-view="customViewFormatter"
                            data-show-custom-view-button="false" data-ajax="all_product" data-toggle="table">
                            <thead>
                                <tr>
                                    <th data-field="title">Name</th>
                                    <th data-field="image"></th>
                                    <th data-field="saleprice">Following</th>
                                    <th data-field="id">Snippets</th>
                                </tr>
                            </thead>
                        </table>


                        <div class="products mb-3">
                            <template id="profileTemplate">
                                <div class="col-6 col-md-4 col-lg-4">
                                    <div class="product product-7 text-center">
                                        <figure class="product-media">
                                            <span class="product-label label-new">New</span>
                                            <a href="#!" onclick="redirect_to_details(%PRODUCT_ID%)">
                                                <img src="{{ asset('') }}%PRODUCT_PICTURE%" alt="Product image"
                                                    class="product-image">
                                            </a>

                                            <div class="product-action-vertical"
                                                onclick="remove_wishlist(%WISH_PRODUCT_ID%)">
                                                <a href="#!" class="btn-product-icon  btn-expandable">
                                                    <i class="fas fa-trash"></i>
                                                    <span>Remove</span>
                                                </a>
                                            </div><!-- End .product-action-vertical -->

                                            {{-- <div class="product-action">
                                                <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                            </div><!-- End .product-action --> --}}
                                        </figure><!-- End .product-media -->

                                        <div class="product-body">
                                            <!-- End .product-cat -->
                                            <h3 class="product-title"><a href="product.html">%NAME%</a>
                                            </h3><!-- End .product-title -->
                                            <div class="product-price">
                                                $%PRICE%
                                            </div><!-- End .product-price -->


                                        </div><!-- End .product-body -->
                                    </div><!-- End .product -->
                                </div><!-- End .col-sm-6 col-lg-4 -->
                            </template>
                        </div>


                        <!-- end test -->


                    </div><!-- End .col-lg-9 -->

                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->
    <div style="display: none" id="product_click_loder">
        @include('font.loading.productLoding')
    </div>

@section('javascript')
    @include('font.js.wishlistjs')
@endsection
@endsection
