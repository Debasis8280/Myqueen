<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="" target="_blank" class="brand-link">
        <img src="{{ asset('asset/image/logo-text.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Visit Store</span>
    </a>
    <div class="sidebar">
        <div class="form-inline">
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item menu-open">
                    <a href="{{ route('admin.dashboard.index') }}"
                        class="nav-link  {{ request()->routeIs('admin.dashboard.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ route('admin.inventory.index') }}"
                        class="nav-link {{ request()->routeIs('admin.inventory.index') || request()->routeIs('admin.product.create') || request()->routeIs('admin.product.edit') ? 'active' : '' }}">
                        <img src="{{ asset('asset/image/icon/inventory.png') }}" alt="" width="30"
                            class="nav-icon">
                        <p>Inventory</p>
                    </a>
                </li>



                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}"
                        class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                        <img src="{{ asset('asset/image/icon/man.png') }}" alt="" width="30" class="nav-icon">
                        <p>Users</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ URL::signedRoute('admin.orders.index') }}"
                        class="nav-link {{ request()->routeIs('admin.orders.index') || request()->routeIs('admin.show_order_details') ? 'active' : '' }}">
                        <img src="{{ asset('asset/image/icon/shopping-bag.png') }}" alt="" width="30"
                            class="nav-icon">
                        <p>Orders</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ URL::signedRoute('admin.payment.index') }}"
                        class="nav-link {{ request()->routeIs('admin.payment.index') ? 'active' : '' }}">
                        <img src="{{ asset('asset/image/icon/payment-method.png') }}" alt="" width="30"
                            class="nav-icon">
                        <p>Payment</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ URL::signedRoute('admin.promotion.index') }}"
                        class="nav-link {{ request()->routeIs('admin.promotion.index') ? 'active' : '' }}">
                        <img src="{{ asset('asset/image/icon/promotion.png') }}" alt="" width="30"
                            class="nav-icon">
                        <p>Promotion</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.coupon.index') }}"
                        class="nav-link {{ request()->routeIs('admin.coupon.index') ? 'active' : '' }}">
                        <img src="{{ asset('asset/image/icon/coupon.png') }}" alt="" width="30"
                            class="nav-icon">
                        <p>Coupon</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.shipc.index') }}"
                        class="nav-link {{ request()->routeIs('admin.shipc.index') ? 'active' : '' }}">
                        <img src="{{ asset('asset/image/icon/charge.png') }}" alt="" width="30"
                            class="nav-icon">
                        <p>Shipping Charges</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.barcode.index') }}"
                        class="nav-link {{ request()->routeIs('admin.barcode.index') ? 'active' : '' }}">
                        <img src="{{ asset('asset/image/icon/barcode.png') }}" alt="" width="30"
                            class="nav-icon">
                        <p>Barcode</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.banner.index') }}"
                        class="nav-link {{ request()->routeIs('admin.banner.index') ? 'active' : '' }}">
                        <img src="{{ asset('asset/image/icon/flag.png') }}" alt="" width="30" class="nav-icon">
                        <p>Banner</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
