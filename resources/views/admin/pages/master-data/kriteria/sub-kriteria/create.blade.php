@extends('admin.layouts.app')

@section('tittle', 'Data Periode')
@section('content')
    <!-- container -->
    <div class="container-fluid mg-t-20">

        <!-- breadcrumb -->
        @include('admin.layouts.menu._breadcrumb', [
            'page' => 'Data Kriteria',
            'active' => 'Tambah Sub Data',
        ])
        <!-- breadcrumb -->

        <!-- row opened -->
        <div class="row row-sm">
            <div class="col-xl-12">
                @include('generals._validation')
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Tambah Sub Data Kriteria</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.master-data.sub-kategori.store', $kriteriaPenilaian->id) }}"
                            method="POST">
                            @csrf
                            {{-- <input type="hidden" name="id_kriteria" value="{{ $kriteriaPenilaian->id }}"> --}}
                            <p class="text-danger">* wajib di isi</p>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Nama Sub Kriteria <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <input
                                        class="form-control form-control-sm @error('nama_sub_kriteria') is-invalid @enderror"
                                        name="nama_sub_kriteria" placeholder="Masukkan Nama Sub Kriteria" type="text"
                                        value="{{ old('nama_sub_kriteria') }}">
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Bobot Sub Kriteria <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <input
                                        class="form-control form-control-sm @error('nilai_sub_kriteria') is-invalid @enderror"
                                        name="nilai_sub_kriteria" placeholder="Masukkan Bobot Sub Kriteria" type="number"
                                        value="{{ old('nilai_sub_kriteria') }}">
                                </div>
                            </div>
                            <button class="btn btn-sm btn-main-primary pd-x-30 mg-r-5 mg-t-5">Simpan</button>
                            <a href="{{ route('admin.master-data.kategori.index') }}"
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
