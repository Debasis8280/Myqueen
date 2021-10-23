<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Myqueen</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('asset/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="{{ asset('asset/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/OverlayScrollbars.min.css') }}">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('asset/table/bootstrap-table.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/mycss.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/daterangepicker.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    @include('admin.layout.menu')
    <div class="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('asset/image/logo-text.png') }}" alt="AdminLTELogo"
                height="100" width="200">
        </div>
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>

                <li class="nav-item">
                    <img src="{{ asset('asset/image/logo-text.png') }}" alt="myquuen" width="150">
                </li>
            </ul>

            <ul class="ml-auto navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="mr-2 fas fa-envelope"></i> 4 new messages
                            <span class="float-right text-sm text-muted">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="mr-2 fas fa-users"></i> 8 friend requests
                            <span class="float-right text-sm text-muted">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="mr-2 fas fa-file"></i> 3 new reports
                            <span class="float-right text-sm text-muted">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <img src="{{ asset('asset/image/icon/user.png') }}" alt="" class="img-fluid rounded-circle"
                            width="25">
                    </a>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                            class="dropdown-item">
                            <img src="{{ asset('asset/image/icon/logout.png') }}" alt="" width="20"
                                class="nav-icon">
                            <span class="text-sm text-muted">Logout</span>
                        </a>
                        <form action="{{ route('admin.logout') }}" id="logout-form" method="post">@csrf</form>
                    </div>
                </li>

            </ul>
        </nav>
    </div>
    @yield('content')

    <footer class="main-footer">
        <strong>Copyright &copy;2021 <a href=" " target="_blank"> Devoloped By
                BizzmanWeb</a>.</strong>
        All rights reserved.
    </footer>
    <aside class="control-sidebar control-sidebar-dark">
    </aside>
</body>
<script src="{{ asset('asset/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    $(function() {
        var hash = window.location.hash;
        hash && $('ul.nav a[href="' + hash + '"]').tab('show');

        $('.nav-tabs a').click(function(e) {
            $(this).tab('show');
            window.location.hash = this.hash;
        });
    });
</script>
<script src="{{ asset('asset/js/adminlte.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="{{ asset('asset/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('asset/table/tableExport.min.js') }}"></script>
<script script src="{{ asset('asset/table/bootstrap-table.min.js') }}"></script>
<script script src="{{ asset('asset/table/bootstrap-table-export.min.js') }}"></script>
<script src="{{ asset('asset/table/bootstrap-table-mobile.min.js') }}">
</script>
<script src="{{ asset('asset/js/moment.min.js') }}"></script>
<script src="{{ asset('asset/js/daterangepicker.js') }}"></script>

@yield('javascript')
</body>

</html>
