@extends('admin.layouts.app')
@php
    // convert date to datetime-local
    $tgl_awal_penilaian = date('Y-m-d\TH:i:s', strtotime($periode->tgl_awal_penilaian));
    $tgl_akhir_penilaian = date('Y-m-d\TH:i:s', strtotime($periode->tgl_akhir_penilaian));
    
    // dd($tgl_awal_penilaian);
    
@endphp
@section('tittle', 'Data Periode')
@section('content')
    <!-- container -->
    <div class="container-fluid mg-t-20">

        <!-- breadcrumb -->
        @include('admin.layouts.menu._breadcrumb', ['page' => 'Data Periode', 'active' => 'Edit Data'])
        <!-- breadcrumb -->

        <!-- row opened -->
        <div class="row row-sm">
            <div class="col-xl-12">
                @include('generals._validation')
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Edit Data Periode</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.master-data.periode.update', $periode->id) }}" method="POST">
                            @csrf
                            <p class="text-danger">* wajib di isi</p>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Nama Periode <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <input class="form-control form-control-sm @error('nama_periode') is-invalid @enderror"
                                        name="nama_periode" placeholder="Masukkan Nama Periode" type="text"
                                        value="{{ old('nama_periode') ? old('nama_periode') : $periode->nama_periode }}">
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Keterangan</label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <textarea class="form-control form-control-sm @error('keterangan') is-invalid @enderror" name="keterangan"
                                        placeholder="Masukkan Keterangan" type="text">{{ old('keterangan') ? old('keterangan') : $periode->keterangan }}</textarea>
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Tanggal Awal Penilaian <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <input
                                        class="form-control form-control-sm @error('tgl_awal_penilaian') is-invalid @enderror"
                                        name="tgl_awal_penilaian" placeholder="Masukkan Tanggal Awal Penilaian"
                                        type="datetime-local" value="{!! old('tgl_awal_penilaian') ? old('tgl_awal_penilaian') : $tgl_awal_penilaian !!}">
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Tanggal Akhir Penilaian <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <input
                                        class="form-control form-control-sm @error('tgl_akhir_penilaian') is-invalid @enderror"
                                        name="tgl_akhir_penilaian" placeholder="Masukkan Tanggal Akhir Penilaian"
                                        type="datetime-local" value="{!! old('tgl_akhir_penilaian') ? old('tgl_akhir_penilaian') : $tgl_akhir_penilaian !!}">
                                </div>
                            </div>
                            <button class="btn btn-sm btn-main-primary pd-x-30 mg-r-5 mg-t-5">Simpan</button>
                            <a href="{{ route('admin.master-data.periode.index') }}"
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