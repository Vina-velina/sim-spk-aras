<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - @yield('tittle')</title>

    {{-- CSS --}}
    @include('auth.layouts._css')
</head>

<body>
    <!-- [ auth-signin ] start -->
    <div class="auth-wrapper">
        @yield('content')
    </div>
    <!-- [ auth-signin ] end -->

    {{-- JavaScripts --}}
    @include('auth.layouts._js')
</body>

</html>
