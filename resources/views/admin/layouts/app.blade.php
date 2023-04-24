<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - @yield('tittle')</title>

    {{-- CSS --}}
    @include('admin.layouts._css')

</head>

<body class="main-body light-theme app sidebar-mini active leftmenu-color">
    <div class="berhasil" data-berhasil="{{ ucWords(Session::get('success')) }}"></div>
    <div class="gagal" data-gagal="{{ ucWords(Session::get('error')) }}"></div>

    <!-- Loader -->
    <div id="global-loader">
        <img src="{{ asset('assets/img/loader-2.svg') }}" class="loader-img" alt="Loader">
    </div>
    <!-- /Loader -->

    <!-- main-sidebar -->
    @include('admin.layouts._sidebar')
    <!-- main-sidebar -->
    <!-- main-content -->
    <div class="main-content app-content">

        <!-- main-header -->
        @include('admin.layouts._header')
        <!-- /main-header -->
        <!-- container -->
        @yield('content')
        <!-- Container closed -->

    </div>
    <!-- main-content closed -->

    <!-- Footer opened -->
    <div class="main-footer ht-40">
        <div class="container-fluid pd-t-0-f ht-100p">
            <span>Copyright © {{ date('Y') }} <a href="#">SIM SPK Aras</a>. All rights reserved.</span>
        </div>
    </div>
    <!-- Footer closed -->
    <!-- Back-to-top -->
    <a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

    @include('admin.layouts._js')
    @include('generals._sweetalert')
</body>

</html>
