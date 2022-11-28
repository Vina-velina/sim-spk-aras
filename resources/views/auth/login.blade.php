@extends('auth.layouts.app')

@section('tittle', 'Login Aplikasi')

@section('content')
    <div class="auth-content text-center">
        <img src="assets/images/logo-dark.png" alt="" class="img-fluid mb-4">
        <div class="card">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="card-body">
                        <h4 class="mb-3 f-w-400">Masuk Aplikasi</h4>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="input-group mb-3">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group mb-4">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password" placeholder="********">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group text-left mt-2">
                                <div class="checkbox checkbox-primary d-inline">
                                    <input type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember" class="cr"> Ingat Saya</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-block btn-primary mb-4 rounded-pill">Masuk</button>
                            @if (Route::has('password.request'))
                                <p class="mb-2 text-muted">Lupa kata sandi? <a href="{{ route('password.request') }}"
                                        class="f-w-400">Reset Sandi</a></p>
                            @endif

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <svg width="100%" height="250px" version="1.1" xmlns="http://www.w3.org/2000/svg" class="wave bg-wave">
        <title>Wave</title>
        <defs></defs>
        <path id="feel-the-wave" d="" />
    </svg>
    <svg width="100%" height="250px" version="1.1" xmlns="http://www.w3.org/2000/svg" class="wave bg-wave">
        <title>Wave</title>
        <defs></defs>
        <path id="feel-the-wave-two" d="" />
    </svg>
    <svg width="100%" height="250px" version="1.1" xmlns="http://www.w3.org/2000/svg" class="wave bg-wave">
        <title>Wave</title>
        <defs></defs>
        <path id="feel-the-wave-three" d="" />
    </svg>
@endsection
