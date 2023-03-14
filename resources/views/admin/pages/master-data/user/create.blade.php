@extends('admin.layouts.app')

@section('tittle', 'Data User')
@section('content')
    <!-- container -->
    <div class="container-fluid mg-t-20">

        <!-- breadcrumb -->
        @include('admin.layouts.menu._breadcrumb', ['page' => 'Data User', 'active' => 'Tambah Data'])
        <!-- breadcrumb -->

        <!-- row opened -->
        <div class="row row-sm">
            <div class="col-xl-12">
                @include('generals._validation')
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Tambah Data User</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.master-data.user.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Foto User</label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <input class="form-control form-control-sm" name="foto_user" accept=".png,.jpg,.jpeg"
                                        type="file">
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Nama User</label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <input class="form-control form-control-sm" name="nama_user"
                                        placeholder="Masukkan Nama User" type="text">
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Email</label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <input class="form-control form-control-sm" name="email_user"
                                        placeholder="Masukkan Email User" type="email">
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Role</label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <select name="role" class="form-control form-control-sm" id="">
                                        <option value="super_admin" selected>Super Admin</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Password</label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <input class="form-control form-control-sm" name="password" placeholder="********"
                                        type="password">
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Konfirmasi Password</label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <input class="form-control form-control-sm" name="password_confirmation"
                                        placeholder="********" type="password">
                                </div>
                            </div>
                            <button class="btn btn-sm btn-main-primary pd-x-30 mg-r-5 mg-t-5">Simpan</button>
                            <a href="{{ route('admin.master-data.user.index') }}"
                                class="btn btn-sm btn-dark pd-x-30 mg-t-5">Batalkan
                            </a>
                        </form>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div>
        </div>
    </div>

@endsection
