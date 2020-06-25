<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>MyPOS | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('dashboard/img')}}/favicon.png">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('dashboard/plugins')}}/fontawesome-free/css/all.min.css" />
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <!-- Noty -->
    <link rel="stylesheet" href="{{asset('dashboard/plugins')}}/noty/noty.min.css">
    <!-- noty plugin -->
    <script src="{{asset('dashboard/plugins')}}/noty/noty.min.js"></script>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dashboard/css')}}/adminlte.min.css" />

    @if (app()->getLocale() == 'en')

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet" />
    @else
    <!-- Google Font: Cairo -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- bootstrap rtl -->
    <link rel="stylesheet" href="{{asset('dashboard/css')}}/bootstrap-rtl.min.css">
    <!-- template rtl version -->
    <link rel="stylesheet" href="{{asset('dashboard/css')}}/custom-style.css">

    <style>
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Cairo', sans-serif !important;
        }
    </style>
    @endif
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet" />
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('dashboard/plugins')}}/overlayScrollbars/css/OverlayScrollbars.min.css" />
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('dashboard/plugins')}}/daterangepicker/daterangepicker.css" />

</head>

<body class="hold-transition sidebar-mini layout-fixed" dir="{{LaravelLocalization::getCurrentLocaleDirection() }}">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>

                <!-- list of languages of laravelLocalization -->
                <li class="nav-item d-none d-sm-inline-block">
                    <div class="dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">Languages</a>
                        <div class="dropdown-menu" style="min-width: 112px;" aria-labelledby="dropdownMenuButton">
                            <ul class="list-unstyled ml-3">
                                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <li>
                                    <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                        {{ $properties['native'] }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </li>

            </ul>


            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{route('dashboard.logout')}}">
                        <i class="fa fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Include Adminlte Sidebar -->
        @include('layouts.dashboard._aside')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            {{-- include session --}}
            @include('partials._session')
            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <strong>Copyright &copy; 2020 <a href="#">MyPOS</a>.</strong> All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{asset('dashboard/plugins')}}/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('dashboard/plugins')}}/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge("uibutton", $.ui.button);
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('dashboard/plugins')}}/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="{{asset('dashboard/plugins')}}/chart.js/Chart.min.js"></script>
    <!-- daterangepicker -->
    <script src="{{asset('dashboard/plugins')}}/moment/moment.min.js"></script>
    <script src="{{asset('dashboard/plugins')}}/daterangepicker/daterangepicker.js"></script>
    <!-- overlayScrollbars -->
    <script src="{{asset('dashboard/plugins')}}/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('dashboard')}}/js/adminlte.min.js"></script>

    <script>
        $('.delete').click(function(e) {
            //"use strict";
            e.preventDefault();
            var that = $(this);

            var noty = new Noty({
                text: 'Are you sure you want to delete?',
                type: 'warning',
                layout: 'topRight',
                killer: true,
                buttons: [
                    Noty.button('Yes', 'btn btn-success mr-2', function () {
                        that.closest('form').submit();
                    }),
                    Noty.button('No', 'btn btn-primary', function() {
                        noty.close();
                    })
                ]
            });
            noty.show();
        });
    </script>

</body>

</html>
