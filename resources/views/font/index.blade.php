@extends('font.layouts.main')
@section('content')
    <style>
        body .owl-nav {
            position: initial;
        }

        body .owl-nav div {
            position: absolute;
            top: 40%;
            border: 1px solid #000;
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        body .owl-prev {
            left: -20px;
            display: flex;
            background-color: white;
        }

        body .owl-next {
            right: -20px;
            display: flex;
            background-color: white;
        }

    </style>




    <main class="main">
        <div class="page-content">
            <section class="intro-section">
                <div id="welcome_banner"
                    class="owl-carousel owl-theme row owl-nav-fade intro-slider animation-slider cols-1 gutter-no"
                    data-owl-options="{'nav': false,'dots': false,'loop': false,'items': 1,'autoplay': false,'autoplayTimeout': 8000,'responsive': {'992': {'nav': true}}}">


                </div>
            </section>
            <section class="intro-section">
                <div class="container-fluid pt-4 mt-10 appear-animate"
                    data-animation-options="{'name': 'fadeIn', 'delay': '.3s'}">
                    <h2 class="title title-underline text-center mb-7">Popular Categories</h2>
                    <div class="row gutter-md ">
                        <div class="col-md-4">
                            <div class="height-x1 w-2">
                                <div class="category category-banner category-absolute overlay-dark">
                                    <a href="product-details.html">
                                        <figure class="category-media">
                                            <img src="{{ asset('Popular Product/Cover Image (English) .png') }}"
                                                alt="category" width="480" height="250" />
                                        </figure>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="height-x1 w-2">
                                <div class="category category-banner category-absolute overlay-dark">
                                    <a href="product-details.html">
                                        <figure class="category-media">
                                            <img src="{{ asset('Popular Product/Cover Image (English)  (1).png') }}"
                                                alt="category" width="480" height="250" />
                                        </figure>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="height-x1 w-2">
                                <div class="category category-banner category-absolute overlay-dark">
                                    <a href="product-details.html">
                                        <figure class="category-media">
                                            <img src="{{ asset('Popular Product/Cover Image (English)  (2).png') }}"
                                                alt="category" width="480" height="250" />
                                        </figure>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="height-x1 w-2">
                                <div class="category category-banner category-absolute overlay-dark">
                                    <a href="product-details.html">
                                        <figure class="category-media">
                                            <img src="{{ asset('Popular Product/Cover Image (English)  (3).png') }}"
                                                alt="category" width="480" height="250" />
                                        </figure>
                                    </a>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="height-x1 w-2">
                                <div class="category category-banner category-absolute overlay-dark">
                                    <a href="product-details.html">
                                        <figure class="category-media">
                                            <img src="{{ asset('Popular Product/Cover Image (English)  (4).png') }}"
                                                alt="category" width="480" height="250" />
                                        </figure>
                                    </a>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="height-x1 w-2">
                                <div class="category category-banner category-absolute overlay-dark">
                                    <a href="product-details.html">
                                        <figure class="category-media">
                                            <img src="{{ asset('Popular Product/Cover Image (English)  (5).png') }}"
                                                width="480" height="250" />
                                        </figure>
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="container pt-6 mt-10 text-center appear-animate"
                    data-animation-options="{'name': 'fadeIn', 'delay': '.3s'}">
                    <h2 class="title title-underline text-center">Our Products</h2>
                    <div id="welcome_products" class="owl-carousel owl-theme row  mb-5"
                        data-owl-options="{
                                                                                                                                                                                                            'items': 4,
                                                                                                                                                                                                            'nav': false,
                                                                                                                                                                                                            'dots': false,
                                                                                                                                                                                                            'margin': 20,
                                                                                                                                                                                                            'loop': false,
                                                                                                                                                                                                            'responsive': {
                                                                                                                                                                                                                '0': {
                                                                                                                                                                                                                    'items': 2
                                                                                                                                                                                                                },
                                                                                                                                                                                                                '768': {
                                                                                                                                                                                                                    'items': 3
                                                                                                                                                                                                                },
                                                                                                                                                                                                                '992': {
                                                                                                                                                                                                                    'items': 5
                                                                                                                                                                                                                }
                                                                                                                                                                                                            }
                                                                                                                                                                                                        }">


                    </div>
                    <a href="{{ URL::signedRoute('users.view_product_list') }}"
                        class="btn btn-outline btn-rounded btn-dark mb-4">View All
                        Products</a>
                </div>
            </section>
        </div>
    </main>

    <div style="display: none" id="product_click_loder">
        @include('font.loading.productLoding')
    </div>


@section('javascript')
    @include('font.js.indexjs')
@endsection

@endsection
