<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>@yield('title', 'Asset Inventory Management System')</title>

    <!-- Open Graph Meta -->
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="assets/media/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/media/favicons/favicon-192x192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/media/favicons/apple-touch-icon-180x180.png">

    <!-- END Icons -->

    <!-- Stylesheets -->
    <!-- Dashmix framework -->
    <link rel="stylesheet" id="css-main" href="{{ url('/assets/css/dashmix.min.css') }}">
    <link rel="stylesheet" id="css-main" href="{{ url('/assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('css')

    @stack('scripts_top')
</head>

<body>

    <div id="page-container"
        class="sidebar-o sidebar-scroll page-header-dark enable-page-overlay side-scroll page-header-fixed">

        @include('includes.sidebar')
        @include('includes.header')

        @yield('content')
        @include('includes.footer')

    </div>

    <script src="{{ url('/assets/js/dashmix.app.min.js') }} "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

    <!-- jQuery (required for DataTables plugin) -->
    <script src="{{ url('/assets/js/lib/jquery.min.js') }}"></script>


    @stack('scripts')
</body>

</html>
