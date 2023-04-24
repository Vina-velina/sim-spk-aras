@extends('admin.layouts.app')

@section('tittle', 'Keamanan Akun')
@section('otherJsPlugin')
@endsection

@section('content')
    <!-- container -->
    <div class="container-fluid mg-t-20">

        <!-- breadcrumb -->
        @include('admin.layouts.menu._breadcrumb', ['page' => 'Keamanan Akun', 'active' => 'Index'])
        <!-- breadcrumb -->
        @include('generals._validation')

        @include('admin.pages.account._tab')
        <!-- row opened -->
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Keamanan Akun</h6>
                    </div>
                    <form action="{{ route('admin.account.update-password') }}" method="POST">
                        <div class="card-body row row-xs">
                            @csrf
                            <div class="col-12">
                                <p class="text-danger">* Wajib diisi</p>

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
                                        <label class="form-label mg-b-0">Verifikasi Password Lama <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-12 mg-t-5">
                                        <input class="form-control form-control-sm @error('password') is-invalid @enderror"
                                            name="password" placeholder="Masukkan Password" value="" type="password">
                                        <small>Wajib diisi jika ingin mengganti password</small>
                                    </div>
                                </div>
                            </div>
                        </div><!-- bd -->
                        <div class="card-footer">
                            <div class="d-flex justify-content-end w-100">
                                <button type="submit" class="btn ripple btn-sm btn-primary mr-2">Simpan Perubahan</button>
                                <a class="btn ripple btn-sm btn-secondary" href="{{ route('admin.home') }}">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div><!-- bd -->
            </div>
        </div>
    </div>
@endsection
