@extends('admin.layouts.app')

@section('tittle', 'Data Debitur')
@section('content')
    <!-- container -->
    <div class="container-fluid mg-t-20">

        <!-- breadcrumb -->
        @include('admin.layouts.menu._breadcrumb', ['page' => 'Data Debitur', 'active' => 'Ubah Data'])
        <!-- breadcrumb -->

        <!-- row opened -->
        <div class="row row-sm">
            <div class="col-xl-12">
                @include('generals._validation')
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Ubah Data Debitur</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.master-data.debitur.update', $detail->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div class="row mg-b-20">
                                <div class="col-md-3">
                                    {{-- preview image --}}
                                    <div style="width: 200px; height: 200px;">
                                        @if ($detail->foto)
                                            <img alt="photo" src="{{ asset('storage/foto-debitur/' . $detail->foto) }}"
                                                style="object-fit: cover; object-position: center; width: 200px; height: 200px;"
                                                class="preview-image img-thumbnail rounded-circle">
                                        @else
                                            <img alt="photo"
                                                src="https://ui-avatars.com/api/?name={{ $detail->nama }}&background=5066e0&color=fff"
                                                style="object-fit: cover; object-position: center; width: 200px; height: 200px;"
                                                class="preview-image img-thumbnail rounded-circle">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <p class="text-danger">* Wajib diisi</p>
                                    <div class="row row-xs align-items-center mg-b-20">
                                        <div class="col-md-12">
                                            <label class="form-label mg-b-0">Foto Debitur</label>
                                        </div>
                                        <div class="col-md-12 mg-t-5">
                                            <input
                                                class="form-control form-control-sm @error('foto_debitur') is-invalid @enderror"
                                                name="foto_debitur" accept=".png,.jpg,.jpeg" type="file">
                                        </div>
                                    </div>
                                    <div class="row row-xs align-items-center mg-b-20">
                                        <div class="col-md-12">
                                            <label class="form-label mg-b-0">Nama Debitur <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-12 mg-t-5">
                                            <input
                                                class="form-control form-control-sm @error('nama_debitur') is-invalid @enderror"
                                                name="nama_debitur" placeholder="Masukkan Nama Debitur"
                                                value="{{ old('nama_debitur') ? old('nama_debitur') : $detail->nama }}"
                                                type="text">
                                        </div>
                                    </div>
                                    <div class="row row-xs align-items-center mg-b-20">
                                        <div class="col-md-12">
                                            <label class="form-label mg-b-0">Alamat Debitur <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-12 mg-t-5">
                                            <textarea class="form-control form-control-sm @error('alamat_debitur') is-invalid @enderror" rows="5"
                                                name="alamat_debitur" placeholder="Masukkan Alamat Debitur" type="text">{{ old('alamat_debitur') ? old('alamat_debitur') : $detail->alamat }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row row-xs align-items-center mg-b-20">
                                        <div class="col-md-12">
                                            <label class="form-label mg-b-0">Pekerjaan Debitur</label>
                                        </div>
                                        <div class="col-md-12 mg-t-5">
                                            <input
                                                class="form-control form-control-sm @error('pekerjaan_debitur') is-invalid @enderror"
                                                name="pekerjaan_debitur" placeholder="Masukkan Pekerjaan Debitur"
                                                value="{{ old('pekerjaan_debitur') ? old('pekerjaan_debitur') : $detail->pekerjaan }}"
                                                type="text">
                                        </div>
                                    </div>
                                    <div class="row row-xs align-items-center mg-b-20">
                                        <div class="col-md-12">
                                            <label class="form-label mg-b-0">Nomor Telepon/WhatsApp</label>
                                        </div>
                                        <div class="col-md-12 mg-t-5">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">+62</span>
                                                </div>
                                                <input
                                                    class="form-control form-control-sm @error('nomor_telepon') is-invalid @enderror"
                                                    value="{{ old('nomor_telepon') ? old('nomor_telepon') : $detail->no_telp }}"
                                                    name="nomor_telepon" placeholder="8xxxxxxxxxx"
                                                    onkeyup="this.value = +this.value.replace(/[^0-9]/g, '');"
                                                    type="text">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row row-xs align-items-center mg-b-20">
                                        <div class="col-md-12">
                                            <label class="form-label mg-b-0">Status <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-12 mg-t-5">
                                            <select name="status"
                                                class="form-control form-control-sm @error('status') is-invalid @enderror"
                                                id="">
                                                <option value="aktif" {{ $detail->status == 'aktif' ? 'selected' : '' }}>
                                                    Aktif
                                                </option>
                                                <option value="nonaktif"
                                                    {{ $detail->status == 'nonaktif' ? 'selected' : '' }}>
                                                    Non
                                                    Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-main-primary pd-x-30 mg-r-5 mg-t-5">Simpan</button>
                                    <a href="{{ route('admin.master-data.debitur.index') }}"
                                        class="btn btn-sm btn-dark pd-x-30 mg-t-5">Batalkan
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div>
            <!--/div-->
        </div>
    </div>

@endsection

@section('otherJsQuery')
    <script>
        $(document).ready(function() {
            // $('.preview-image-col').hide();
            $('input[name="foto_debitur"]').change(function() {
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
