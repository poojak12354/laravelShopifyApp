<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ url('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link href="{{ url('assets/vendors/css/vendor.bundle.base.css') }}" rel="stylesheet">
    <link href="{{ url('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ url('assets/css/custom-style.css') }}" rel="stylesheet">
    <script src="{{ url('assets/vendors/js/vendor.bundle.base.js') }}" defer></script>
</head>
<body class="sidebar-icon-only">
    
                <div id="app">
                    <div class="container-scroller">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12 pge-ttle">
                                    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 d-flex flex-row">
                                        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                                            <a class="navbar-brand brand-logo" href="javascript:void(0)">{{ config('app.name', 'Laravel') }}</a>
                                            <a class="navbar-brand brand-logo-mini" href="javascript:void(0)">{{ config('app.name', 'Laravel') }}</a>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        
                        <div class="container-fluid page-body-wrapper full-page-wrapper">
                            <div class="content-wrapper">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
</body>
</html>
