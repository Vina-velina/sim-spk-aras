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
    @include('auth.layouts._css')

</head>

<body class="main-body light-theme">
    <div class="berhasil" data-berhasil="{{ Session::get('success') }}"></div>
    <div class="gagal" data-gagal="{{ Session::get('error') }}"></div>

    <!-- Loader -->
    <div id="global-loader">
        <img src="{{ asset('assets/img/loader-2.svg') }}" class="loader-img" alt="Loader">
    </div>
    <!-- /Loader -->

    <!-- main-signin-wrapper -->
    <div class="my-auto page page-h">
        @yield('content')
    </div>
    <!-- /main-signin-wrapper -->
    @include('auth.layouts._js')
    @include('generals._sweetalert')
</body>

</html>
