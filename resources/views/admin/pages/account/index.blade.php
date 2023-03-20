@extends('admin.layouts.app')

@section('tittle', 'Data Akun')
@section('otherJsPlugin')
@endsection

@section('content')
    <!-- container -->
    <div class="container-fluid mg-t-20">

        <!-- breadcrumb -->
        @include('admin.layouts.menu._breadcrumb', ['page' => 'Data Akun', 'active' => 'Index'])
        <!-- breadcrumb -->
        @include('generals._validation')

        <!-- row opened -->
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Detail Akun</h6>
                    </div>
                    <form action="{{ route('admin.account.update') }}" method="POST" enctype="multipart/form-data">
                        <div class="card-body row row-xs">
                            @csrf
                            <div class="col-md-4 col-12">
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
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-12">
                                        <label class="form-label mg-b-0">Foto Profil</label>
                                    </div>
                                    <div class="col-md-12 mg-t-5">
                                        <input class="form-control form-control-sm" name="foto_profil"
                                            placeholder="Masukkan Image" type="file">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-12">
                                        <label class="form-label mg-b-0">Nama</label>
                                    </div>
                                    <div class="col-md-12 mg-t-5">
                                        <input class="form-control form-control-sm" name="name"
                                            placeholder="Masukkan Nama" value="{{ Auth::user()->name }}" type="text">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-12">
                                        <label class="form-label mg-b-0">Email</label>
                                    </div>
                                    <div class="col-md-12 mg-t-5">
                                        <input class="form-control form-control-sm" name="email"
                                            placeholder="Masukkan Email" type="email" value="{{ Auth::user()->email }}">
                                    </div>
                                </div>
                                {{-- <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-12">
                                        <label class="form-label mg-b-0">Password</label>
                                    </div>
                                    <div class="col-md-12 mg-t-5">
                                        <input class="form-control form-control-sm" name="password"
                                            placeholder="Masukkan Password" value="" type="password">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-12">
                                        <label class="form-label mg-b-0">Konfirmasi Password</label>
                                    </div>
                                    <div class="col-md-12 mg-t-5">
                                        <input class="form-control form-control-sm" name="password_confirmation"
                                            placeholder="Masukkan Password" value="" type="password">
                                    </div>
                                </div> --}}

                            </div>
                            {{-- <div class="col-md-4 col-12">
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-12">
                                        <label class="form-label mg-b-0">Nomor Telepon/WhatsApp</label>
                                    </div>
                                    <div class="col-md-12 mg-t-5">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">+62</span>
                                            </div>
                                            <input class="form-control form-control-sm" value="" name="nomor_telepon"
                                                placeholder="8xxxxxxxxxx" type="number">
                                        </div>
                                    </div>

                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-12">
                                        <label class="form-label mg-b-0">Nomor KTP</label>
                                    </div>
                                    <div class="col-md-12 mg-t-5">
                                        <input class="form-control form-control-sm" name="nomor_ktp"
                                            placeholder="xxxxxxxxxxxxxxxx" value="" type="number">
                                    </div>
                                </div>
                            </div> --}}

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
