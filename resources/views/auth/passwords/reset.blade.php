@extends('auth.layouts.app')
@section('tittle', 'Perbaharui Kata Sandi')
@section('content')
    <!-- [ change-password ] start -->
    <div class="auth-content text-center">
        <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" class="img-fluid mb-4">
        <div class="card ">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="card-body">
                        <div class="text-center">
                            <h4 class="mb-4 f-w-400">Perbaharui kata sandi</h4>
                        </div>
                        @include('generals._validation')
                        <form method="POST" action="{{ route('reset.password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="input-group mb-4">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group mb-4">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password" placeholder="********">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group mb-4">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="********">
                            </div>
                            <button class="btn btn-block btn-primary mb-4 rounded-pill">Simpan sandi baru</button>
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
    <!-- [ change-password ] end -->
@endsection
