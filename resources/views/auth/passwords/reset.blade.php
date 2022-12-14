@extends('auth.layouts.app')
@section('tittle', 'Perbaharui Kata Sandi')
@section('content')
    <!-- main-signin-wrapper -->
    <div class="my-auto page page-h">
        <div class="main-signin-wrapper error-wrapper">
            <div class="main-card-signin d-md-flex wd-100p">
                <div class="wd-md-50p login d-none d-md-block page-signin-style p-5 text-white">
                    <div class="my-auto authentication-pages">
                        <div>
                            <img src="{{ config('general.icon-text-white') }}" alt="logo" class="m-0 w-75 mb-4">
                            <h5 class="mb-4">Sistem Informasi Manajemen Pendukung Keputusan Metode ARAS</h5>
                            <p class="mb-5">Sistem informasi ini dikembangkan guna membantu Koperasi dalam meningkatkan
                                minat pembayaran tagihan debitur melalui program pemberian penghargaan bagi debitur terbaik,
                                dimana proses perhitungan ini menggunakan salah satu metode dalam Sistem Pendukung Keputusan
                                yaitu Metode ARAS</p>
                        </div>
                    </div>
                </div>
                <div class="p-5 wd-md-50p">
                    <div class="main-signin-header">
                        <h2>Perbaharui Kata Sandi!</h2>
                        <h4>Masukkan kata sandi baru</h4>
                        <form method="POST" action="{{ route('reset.password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Kata Sandi Baru</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password" placeholder="********">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password-confirm">Ulangi Kata Sandi Baru</label>
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="********">
                            </div>
                            <button type="submit" class="btn btn-main-primary btn-block">Ubah Kata Sandi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /main-signin-wrapper -->
@endsection
