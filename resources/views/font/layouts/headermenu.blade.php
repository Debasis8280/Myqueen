<header class="header">
    <div class="header-top">
        <div class="container-fluid">
            <div class="header-left">
                <div class="welcome-msg">
                    <a href="contact-us.html" class="contact"><i class="d-icon-map"></i>
                        {{ __('index.find_myqueen_store') }}
                    </a>
                </div>
            </div>
            <div class="header-right">

                <a class="call" href="tel:#06567219257">
                    <i class="d-icon-phone"></i>
                    <span>Call us: </span>+6567219257
                </a>
                @auth
                    <a href="{{ URL::signedRoute('users.wishlist.index') }}" class="wishlist"><i
                            class="d-icon-heart"></i>Wishlist</a>
                    <div class="dropdown ml-5">
                        <a href="#"><i class="d-icon-user"></i> &nbsp;
                            My
                            Account</a>
                        <ul class="dropdown-box">
                            <li><a href="{{ URl::signedRoute('users.profile.index') }}">Profile</a></li>
                            @if (Auth::user()->is_mlm_member == 1)
                                <li><a href="{{ URL::signedRoute('MLM.register.index') }}">MLM</a></li>
                            @endif
                            <li><a href="{{ route('users.purchase_history.index') }}">Order History</a></li>
                            <li><a href="{{ URL::signedRoute('users.show_wallet_page') }}">Credit Wallet</a></li>
                            <li><a href="{{ URL::signedRoute('users.show_royalty') }}">Royalty Point Wallet </a></li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
    document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>


                    <div class="dropdown cart-dropdown  type3 ml-2">
                        <a href="{{ URL::signedRoute('users.cart.index') }}" class="cart-toggle">
                            <i class="d-icon-bag"></i>
                            My Cart <span id="all_cart_count"> </span>
                        </a>
                        <div class="cart-overlay"></div>
                    </div>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="___class_+?15___"><i class="d-icon-user"></i> &nbsp;
                        Login/Sign up
                    </a>
                @endguest


                <div class="dropdown">
                    <a href="#currency">USD</a>
                    <ul class="dropdown-box">
                        <li><a href="#USD">USD</a></li>
                    </ul>
                </div>
                <div class="dropdown ml-5">
                    @if (Config::get('app.locale') == 'en')
                        <span class="selected-language">
                            English
                        </span>
                    @elseif(Config::get('app.locale') == 'ch-s')
                        <span class="selected-language">
                            Chinese (Simplified)
                        </span>
                    @else
                        <span class="selected-language">
                            Chinese (Traditional)
                        </span>
                    @endif
                    <ul class="dropdown-box">
                        <a class="dropdown-item " href="{{ route('change.lang', 'en') }}" data-language="en">
                            <i class="flag-icon flag-icon-us mr-50"></i>
                            English</a>
                        <a class="dropdown-item " href="{{ route('change.lang', 'ch-s') }}" data-language="fr">
                            <i class="flag-icon flag-icon-ch mr-50"></i>
                            Chinese (Simplified)
                        </a>
                        <a class="dropdown-item" href="{{ route('change.lang', 'ch-t') }}" data-language="de">
                            <i class="flag-icon flag-icon-ch mr-50"></i>
                            Chinese (Traditional)
                        </a>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End HeaderTop -->
    <div class="header-middle sticky-header fix-top sticky-content">
        <div class="container">
            <div class="header-left">
                <a href="#" class="mobile-menu-toggle mr-0">
                    <i class="d-icon-bars2"></i>
                </a>
                <a href="{{ route('users.index') }}" class="logo d-none d-lg-block">
                    <img src="{{ asset('asset/image/font/logo.png') }}" alt="logo" class="img-responsive" />
                </a>
                <!-- End Logo -->
            </div>
            <div class="header-center d-flex justify-content-center">
                <a href="demo-beauty.html" class="logo d-block d-lg-none">
                    <img src="{{ asset('asset/image/font/logo.png') }}" alt="logo" width="154" height="43" />
                </a>
                <!-- End Logo -->
            </div>
            <div class="header-right">
                <nav class="main-nav mr-4">
                    <ul class="menu menu-active-underline">
                        <li class="{{ request()->routeIs('users.index') ? 'active' : '' }}">
                            <a href="{{ route('users.index') }}">Home</a>
                        </li>
                        <li class="{{ request()->routeIs('users.aboutus') ? 'active' : '' }}">
                            <a href="{{ route('users.aboutus') }}">About Us</a>
                        </li>
                        <li
                            class="{{ request()->routeIs('users.view_product_list') || request()->routeIs('users.product_details.show') ? 'active' : '' }}">
                            <a href="{{ URL::signedRoute('users.view_product_list') }}">Products</a>
                        </li>

                        <li class=" {{ request()->routeIs('users.contactus') ? 'active' : '' }}">
                            <a href="{{ route('users.contactus') }}">Contact Us</a>

                        </li>

                    </ul>
                </nav>


                <span class="divider mr-4"></span>
                <div class="header-search hs-toggle d-block">
                    <a href="#" class="search-toggle d-flex align-items-center">
                        <i class="d-icon-search"></i>
                    </a>
                    <form action="#" class="input-wrapper">
                        <input type="text" class="form-control" name="search" autocomplete="off"
                            placeholder="Search your keyword..." required />
                        <button class="btn btn-search" type="submit">
                            <i class="d-icon-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
