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
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Nama Debitur</label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <input class="form-control form-control-sm" name="nama_debitur"
                                        placeholder="Masukkan Nama Debitur" value="{{ $detail->nama }}" type="text">
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Alamat Debitur</label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <textarea class="form-control form-control-sm" rows="5" name="alamat_debitur"
                                        placeholder="Masukkan Alamat Debitur" type="text">{{ $detail->alamat }}</textarea>
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Pekerjaan Debitur</label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <input class="form-control form-control-sm" name="pekerjaan_debitur"
                                        placeholder="Masukkan Pekerjaan Debitur" value="{{ $detail->pekerjaan }}"
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
                                        <input class="form-control form-control-sm" value="{{ $detail->no_telp }}"
                                            name="nomor_telepon" placeholder="8xxxxxxxxxx"
                                            onkeyup="this.value = +this.value.replace(/[^0-9]/g, '');" type="text">
                                    </div>
                                </div>

                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Nomor KTP</label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <input class="form-control form-control-sm" name="nomor_ktp"
                                        placeholder="xxxxxxxxxxxxxxxx"
                                        onkeyup="this.value = +this.value.replace(/[^0-9]/g, '');"
                                        value="{{ $detail->no_ktp }}" type="text">
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Status</label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <select name="status" class="form-control form-control-sm" id="">
                                        <option value="aktif" {{ $detail->status == 'aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="nonaktif" {{ $detail->status == 'nonaktif' ? 'selected' : '' }}>
                                            Non
                                            Aktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Foto Debitur</label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <input class="form-control form-control-sm" name="foto_debitur" accept=".png,.jpg,.jpeg"
                                        type="file">
                                </div>
                            </div>
                            <button class="btn btn-sm btn-main-primary pd-x-30 mg-r-5 mg-t-5">Simpan</button>
                            <a href="{{ route('admin.master-data.debitur.index') }}"
                                class="btn btn-sm btn-dark pd-x-30 mg-t-5">Batalkan
                            </a>
                        </form>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div>
            <!--/div-->
        </div>
    </div>

@endsection
