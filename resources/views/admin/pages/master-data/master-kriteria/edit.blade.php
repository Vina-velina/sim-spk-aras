@extends('admin.layouts.app')

@section('tittle', 'Data Master Kriteria')
@section('content')
    <!-- container -->
    <div class="container-fluid mg-t-20">

        <!-- breadcrumb -->
        @include('admin.layouts.menu._breadcrumb', [
            'page' => 'Data Master Kriteria',
            'active' => 'Edit Data',
        ])
        <!-- breadcrumb -->

        <!-- row opened -->
        <div class="row row-sm">
            <div class="col-xl-12">
                @include('generals._validation')
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Edit Data Master Kriteria</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.master-data.master-kategori.update', $kriteria->id) }}" method="POST">
                            @csrf
                            <p class="text-danger">* wajib di isi</p>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Nama Kriteria <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <input class="form-control form-control-sm @error('nama_kriteria') is-invalid @enderror"
                                        name="nama_kriteria" placeholder="Masukkan Nama Periode" type="text"
                                        value="{{ old('nama_kriteria') ? old('nama_kriteria') : $kriteria->nama_kriteria }}">
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Keterangan</label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <textarea class="form-control form-control-sm @error('keterangan') is-invalid @enderror" name="keterangan"
                                        placeholder="Masukkan Keterangan" type="text">{!! old('keterangan') ? old('keterangan') : $kriteria->keterangan !!}</textarea>
                                </div>
                            </div>
                            <button class="btn btn-sm btn-main-primary pd-x-30 mg-r-5 mg-t-5">Simpan</button>
                            <a href="{{ route('admin.master-data.master-kategori.index') }}"
                                class="btn btn-sm btn-dark pd-x-30 mg-t-5">Batalkan
                            </a>
                        </form>
                    </div>
                </div>
                <!-- bd -->
            </div>
        </div>
    </div>

@endsection
