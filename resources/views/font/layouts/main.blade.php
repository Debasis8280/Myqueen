<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>Myqueen</title>

    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('asset/css/adminlte.css') }}">

    <link rel="icon" type="image/png" href="{{ asset('asset/image/font/favicon.png') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/font/animate.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/font/magnific-popup.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/font/owl.carousel.min.css') }}">



    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/font/demo-beauty.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('asset/css/font/style.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('asset/alert/toastr.min.css') }}">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('asset/table/bootstrap-table.min.css') }}">

    <style>
        .breadcrumb {
            background-color: white;
        }

    </style>

</head>

<body>
    @include('font.loading.index')
    <div class="page-wrapper">
        @include('font.layouts.headermenu')

        @include('font.layouts.mobilemenu')

        @yield('content')


        <footer class="footer">
            <div class="container">
                <div class="footer-middle">
                    <div class="row">
                        <div class="col-lg-4 col-md-12">
                            <div class="widget widget-about">
                                <a href="demo-beauty.html" class="logo-footer">
                                    <img src="{{ asset('asset/image/font/footer-logo.png') }}" alt="logo-footer"
                                        width="154" height="43">
                                </a>
                                <div class="widget-body">

                                </div>
                            </div>
                            <!-- End Widget -->
                        </div>
                        <div class="col-lg-8 col-md-12">
                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="widget">
                                        <h4 class="widget-title">About Us</h4>
                                        <ul class="widget-body">
                                            <li>
                                                <a href="{{ route('users.aboutus') }}">About Us</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('users.contactus') }}">Contact Us</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- End Widget -->
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="widget">
                                        <h4 class="widget-title">Customer Service</h4>
                                        <ul class="widget-body">

                                            <li>
                                                <a href="#">Custom Service</a>
                                            </li>
                                            <li>
                                                <a href="#">Terms &amp; Conditions</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- End Widget -->
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="mb-0 widget">
                                        <h4 class="widget-title">My Account</h4>
                                        <ul class="widget-body">
                                            @if (!Auth::user())
                                                <li>
                                                    <a href="">Sign in</a>
                                                </li>
                                            @else
                                                <li>
                                                    <a href="">My Profile</a>
                                                </li>
                                            @endif
                                            <li>
                                                <a href="">View Cart</a>
                                            </li>
                                            <li>
                                                <a href="wishlist.html">My Wishlist</a>
                                            </li>
                                            <li>
                                                <a href="">Track My Order</a>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- End Footer Middle -->
                <div class="footer-bottom">
                    <div class="footer-left">
                        <figure class="payment">
                            Powered By
                            <img src="{{ asset('asset/image/font/mctpay1.png') }}" alt="payment" width="159"
                                height="29">
                        </figure>
                    </div>
                    <div class="footer-center">
                        <p class="copyright">My Queen © 2021. All Rights Reserved. Developed By <a
                                href="https://bizzmanweb.sg/">Bizzmanweb</a></p>
                    </div>
                    <div class="footer-right">
                        <div class="social-links">
                            <a href="#" class="social-link social-facebook fab fa-facebook-f"></a>
                            <a href="#" class="social-link social-twitter fab fa-twitter"></a>
                            <a href="#" class="social-link social-linkedin fab fa-linkedin-in"></a>
                            <a href="#" class="social-link social-youtube fab fa-youtube"></a>
                            <a href="#" class="social-link social-wechat fab fa-weixin"></a>

                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="{{ asset('asset/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.6.0/umd/popper.min.js"></script>
    <script src="{{ asset('asset/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('asset/alert/toastr.min.js') }}"></script>
    {{-- <script src="{{ asset('public/frontend/vendor/parallax/parallax.min.js') }}"></script>
    <script src="{{ asset('public/frontend/vendor/isotope/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('public/frontend/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('public/frontend/vendor/elevatezoom/jquery.elevatezoom.min.js') }}"></script>
    <script src="{{ asset('public/frontend/vendor/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('public/frontend/vendor/owl-carousel/owl.carousel.min.js') }}"></script>
    <!-- Main JS File -->
    <script src="{{ asset('public/frontend/js/main.min.js') }}"></script> --}}
    <script src="{{ asset('asset/js/font/parallax.min.js') }}"></script>
    <script src="{{ asset('asset/js/font/owl.carousel.min.js') }}"></script>

    {{-- <script src="{{ asset('asset/table/bootstrap-table-mobile.min.js') }}"></script>
    <script src="{{ asset('asset/table/bootstrap-table-custom-view.js') }}"></script> --}}

    <script src="{{ asset('asset/table/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('asset/table/bootstrap-table-custom-view.js') }}"></script>

    <script src="{{ asset('asset/js/font/main.min.js') }}"></script>

    @yield('javascript')

    <script>
        $(document).ready(function() {
            calculate_cart()
        });

        function calculate_cart() {
            $.ajax({
                url: "{{ URL::signedRoute('users.cart.create') }}",
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    if (data.length > 0)
                        $('#all_cart_count').html('(' + data.length + ')')
                }
            })
        }
    </script>

</body>

</html>
