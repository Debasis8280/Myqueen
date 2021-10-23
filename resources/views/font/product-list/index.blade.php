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
                        <div class="toolbox">
                            <div class="toolbox-left">
                                <div class="toolbox-info">
                                    <!-- Showing <span>9 of 56</span> Products -->
                                </div><!-- End .toolbox-info -->
                            </div><!-- End .toolbox-left -->
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
                                                    class="product-image" width="300">
                                            </a>

                                            <div class="product-action-vertical">
                                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"
                                                    id="wish_hart%ADD_WISH_COLOR_ID%"
                                                    onclick="add_to_wishlist(%ADD_WISH_ID%)" style="color: %ADD_COLOR%">
                                                    <span>add
                                                        to
                                                        wishlist</span></a>
                                            </div><!-- End .product-action-vertical -->

                                            {{-- <div class="product-action">
                                                <a href="#!" class="btn-product btn-cart"
                                                    onclick="add_to_cart(%ADD_CART_ID%)"><span>add to
                                                        cart</span></a>
                                            </div> --}}
                                        </figure>

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

@section('javascript')

    <script>
        function customViewFormatter(data) {
            var template = $('#profileTemplate').html()
            var view = ''
            $.each(data, function(i, row) {
                var add_color = row.active != null ? "red" : '';
                view += template.replace('%NAME%', row.title)
                    .replace('%PRODUCT_PICTURE%', row.image)
                    .replace('%PRICE%', row.saleprice)
                    .replace('%PRODUCT_ID%', row.id)
                    .replace('%ADD_WISH_ID%', row.id)
                    .replace('%ADD_WISH_COLOR_ID%', row.id)
                    .replace('%ADD_COLOR%', add_color)
                // .replace('%ADD_CART_ID%', row.id)
            })

            return `<div class="row justify-content-center">${view}</div>`
        }

        function all_product(params) {
            $.ajax({
                type: "GET",
                url: "{{ URL::signedRoute('users.all_product') }}",
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    params.success(data)
                    $('body').addClass('mainloaded')
                },
                error: function(er) {
                    params.error(er);
                }
            });
        }

        function redirect_to_details(id) {
            $.ajax({
                url: "{{ route('user.product_details.index') }}",
                type: 'get',
                data: {
                    id: id
                },
                cache: false,
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    window.location.href = data
                }
            })
        }

        function add_to_wishlist(id) {
            $.ajax({
                url: "{{ URL::signedRoute('users.wishlist.store') }}",
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    product_id: id
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    if (data.status == 'success') {
                        toastr.options = {
                            "closeButton": true,
                            "newestOnTop": true,
                            "positionClass": "toast-bottom-center"
                        };
                        toastr.success(data.message);

                        $('#wish_hart' + id).css('color', data.color);
                    }
                },
                error: function(errror) {
                    console.log(error)
                }
            })
        }
    </script>
@endsection
@endsection
