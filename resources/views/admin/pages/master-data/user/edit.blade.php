@extends('admin.layouts.app')

@section('tittle', 'Data User')
@section('content')
    <!-- container -->
    <div class="container-fluid mg-t-20">

        <!-- breadcrumb -->
        @include('admin.layouts.menu._breadcrumb', ['page' => 'Data User', 'active' => 'Edit Data'])
        <!-- breadcrumb -->

        <!-- row opened -->
        <div class="row row-sm">
            <div class="col-xl-12">
                @include('generals._validation')
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Edit Data User</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.master-data.user.update', $user->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row mg-b-20">
                                <div class="col-xl-3 col-12">
                                    {{-- preview image --}}
                                    @if ($user->foto_profil)
                                        <img alt="photo" src="{{ asset('storage/foto-user/' . $user->foto_profil) }}"
                                            style="object-fit: cover; object-position: center; width: 200px; height: 200px;"
                                            class="preview-image img-thumbnail rounded-circle">
                                    @else
                                        <img alt="photo"
                                            src="https://ui-avatars.com/api/?name={{ $user->name }}&background=5066e0&color=fff"
                                            style="object-fit: cover; object-position: center; width: 200px; height: 200px;"
                                            class="preview-image img-thumbnail rounded-circle">
                                    @endif
                                </div>
                                <div class="col-xl-9 col-12">
                                    <p class="text-danger">* wajib diisi</p>
                                    <div class="row row-xs align-items-center mg-b-20">
                                        <div class="col-md-12">
                                            <label class="form-label mg-b-0">Foto User <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-12 mg-t-5">
                                            <input
                                                class="form-control form-control-sm @error('foto_profil') is-invalid @enderror"
                                                name="foto_profil" accept=".png,.jpg,.jpeg" type="file">
                                        </div>
                                    </div>
                                    <div class="row row-xs align-items-center mg-b-20">
                                        <div class="col-md-12">
                                            <label class="form-label mg-b-0">Nama User <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-12 mg-t-5">
                                            <input class="form-control form-control-sm @error('name') is-invalid @enderror"
                                                name="name" placeholder="Masukkan Nama User" type="text"
                                                value="{{ old('name') ? old('name') : $user->name }}">
                                        </div>
                                    </div>
                                    <div class="row row-xs align-items-center mg-b-20">
                                        <div class="col-md-12">
                                            <label class="form-label mg-b-0">Email<span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-12 mg-t-5">
                                            <input class="form-control form-control-sm @error('email') is-invalid @enderror"
                                                name="email" placeholder="Masukkan Email User" type="email"
                                                value="{{ old('email') ? old('email') : $user->email }}">
                                        </div>
                                    </div>
                                    <div class="row row-xs align-items-center mg-b-20">
                                        <div class="col-md-12">
                                            <label class="form-label mg-b-0">Role<span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-12 mg-t-5">
                                            <select name="role_user"
                                                class="form-control form-control-sm @error('role_user') is-invalid @enderror"
                                                id="">
                                                @if ($user->role_user == 'super_admin')
                                                    <option value="super_admin" selected>Super Admin</option>
                                                    <option value="admin">Admin</option>
                                                @else
                                                    <option value="super_admin">Super Admin</option>
                                                    <option value="admin" selected>Admin</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row row-xs align-items-center mg-b-20">
                                        <div class="col-md-12">
                                            <label class="form-label mg-b-0">Password <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-12 mg-t-5">
                                            <input
                                                class="form-control form-control-sm @error('password') is-invalid @enderror"
                                                name="password" placeholder="********" type="password">
                                        </div>
                                    </div>
                                    <div class="row row-xs align-items-center mg-b-20">
                                        <div class="col-md-12">
                                            <label class="form-label mg-b-0">Konfirmasi Password <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-12 mg-t-5">
                                            <input
                                                class="form-control form-control-sm @error('password_confirmation') is-invalid @enderror"
                                                name="password_confirmation" placeholder="********" type="password">
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-main-primary pd-x-30 mg-r-5 mg-t-5">Simpan</button>
                                    <a href="{{ route('admin.master-data.user.index') }}"
                                        class="btn btn-sm btn-dark pd-x-30 mg-t-5">Batalkan
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div><!-- bd -->
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
