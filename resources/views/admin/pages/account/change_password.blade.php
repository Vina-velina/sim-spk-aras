@extends('admin.layouts.app')

@section('tittle', 'Keamanan Akun')
@section('otherJsPlugin')
@endsection

@section('content')
    <!-- container -->
    <div class="container-fluid mg-t-20">

        <!-- breadcrumb -->
        @include('admin.layouts.menu._breadcrumb', ['page' => 'Keamanan', 'active' => 'Index'])
        <!-- breadcrumb -->
        @include('generals._validation')

        <!-- row opened -->
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Keamanan Akun</h6>
                    </div>
                    <div class="row mx-3 justify-content-center">
                        <a href="{{ route('admin.account.index') }}" class="btn btn-outline-primary col-md-5">Profil</a>
                        <div class="col-md-1"></div>
                        <a href="{{ route('admin.account.change-password') }}" class="btn btn-primary col-md-5">Keamanan</a>
                    </div>
                    <form action="{{ route('admin.account.update-password') }}" method="POST">
                        <div class="card-body row row-xs">
                            @csrf
                            {{-- <div class="col-md-4 col-12">
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-12 mg-t-5 text-center">
                                        @if (empty(Auth::user()->foto_profil))
                                            <img style="object-fit: cover;height: 200px;width: 200px;"
                                                class="rounded-circle"
                                                src="https://ui-avatars.com/api/?name={{ Auth::user()->nama_user ?? 'No Name' }}&background=5066e0&color=fff"
                                                alt="Profil">
                                        @else
                                            <img src="{{ asset('storage/images/foto-user/' . Auth::user()->foto_profil) }}"
                                                alt="Profil">
                                        @endif
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-12">
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-12">
                                        <label class="form-label mg-b-0">Password Baru</label>
                                    </div>
                                    <div class="col-md-12 mg-t-5">
                                        <input
                                            class="form-control form-control-sm @error('password_baru') is-invalid @enderror"
                                            name="password_baru" placeholder="Masukkan Password" value=""
                                            type="password">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-12">
                                        <label class="form-label mg-b-0">Konfirmasi Password</label>
                                    </div>
                                    <div class="col-md-12 mg-t-5">
                                        <input
                                            class="form-control form-control-sm @error('password_baru_confirmation') is-invalid @enderror"
                                            name="password_baru_confirmation" placeholder="Masukkan Password" value=""
                                            type="password">
                                    </div>
                                </div>
                                <hr>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-12">
                                        <label class="form-label mg-b-0">Password Lama</label>
                                    </div>
                                    <div class="col-md-12 mg-t-5">
                                        <input class="form-control form-control-sm @error('password') is-invalid @enderror"
                                            name="password" placeholder="Masukkan Password" value="" type="password">
                                    </div>
                                </div>
                            </div>
                        </div><!-- bd -->
                        <div class="card-footer">
                            <div class="d-flex justify-content-between w-100">
                                <a class="btn ripple btn-sm btn-secondary" href="{{ route('admin.home') }}">Kembali</a>
                                <button type="submit" class="btn ripple btn-sm btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div><!-- bd -->
            </div>
        </div>
    </div>
@endsection
