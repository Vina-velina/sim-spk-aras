@extends('admin.layouts.app')

@section('tittle', 'Data Akun')
@section('otherJsPlugin')
@endsection

@section('content')
    <!-- container -->
    <div class="container-fluid mg-t-20">

        <!-- breadcrumb -->
        @include('admin.layouts.menu._breadcrumb', ['page' => 'Informasi Profil', 'active' => 'Index'])
        <!-- breadcrumb -->
        @include('generals._validation')

        @include('admin.pages.account._tab')
        <!-- row opened -->
        <div class="row row-sm">

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Informasi Profil</h6>

                    </div>
                    <form action="{{ route('admin.account.update') }}" method="POST" enctype="multipart/form-data">
                        <div class="card-body row row-xs">
                            @csrf
                            <div class="col-md-4 col-12">
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-12 mg-t-5 text-center">
                                        @if (empty(Auth::user()->foto_profil))
                                            <img style="object-fit: cover;height: 200px;width: 200px;"
                                                class="rounded-circle preview-image"
                                                src="https://ui-avatars.com/api/?name={{ Auth::user()->nama_user ?? 'No Name' }}&background=5066e0&color=fff"
                                                alt="Profil">
                                        @else
                                            <img style="object-fit: cover;height: 200px;width: 200px;"
                                                class="rounded-circle preview-image"
                                                src="{{ asset('storage/foto-user/' . Auth::user()->foto_profil) }}"
                                                alt="Profil">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-12">
                                <p class="text-danger">* Wajib diisi</p>
                                <div class="row align-items-center mg-b-20">
                                    <div class="col-md-12">
                                        <label class="form-label mg-b-0">Foto Profil</label>
                                    </div>
                                    <div class="col-md-12 mg-t-5">
                                        <input
                                            class="form-control form-control-sm @error('foto_porfil') is-invalid @enderror"
                                            accept=".png,.jpg,.jpeg" name="foto_profil" placeholder="Masukkan Image"
                                            type="file">
                                    </div>
                                </div>
                                <div class="row align-items-center mg-b-20">
                                    <div class="col-md-12">
                                        <label class="form-label mg-b-0">Nama <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-12 mg-t-5">
                                        <input class="form-control form-control-sm @error('name') is-invalid @enderror"
                                            name="name" placeholder="Masukkan Nama" value="{{ Auth::user()->name }}"
                                            type="text">
                                    </div>
                                </div>
                                <div class="row align-items-center mg-b-20">
                                    <div class="col-md-12">
                                        <label class="form-label mg-b-0">Email <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-12 mg-t-5">
                                        <input class="form-control form-control-sm @error('email') is-invalid @enderror"
                                            name="email" placeholder="Masukkan Email" type="email"
                                            value="{{ Auth::user()->email }}">
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

@section('otherJsQuery')
    <script>
        $(document).ready(function() {
            // $('.preview-image-col').hide();
            $('input[name="foto_profil"]').change(function() {
                var file = $(this)[0].files[0];
                var reader = new FileReader();
                reader.onload = function() {
                    $('.preview-image').attr('src', reader.result);
                }
                reader.readAsDataURL(file);
                // $('.preview-image-col').show();
            });
        });
    </script>
@endsection
