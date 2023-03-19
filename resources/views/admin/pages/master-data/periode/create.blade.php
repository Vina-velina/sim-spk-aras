@extends('admin.layouts.app')

@section('tittle', 'Data Periode')
@section('content')
    <!-- container -->
    <div class="container-fluid mg-t-20">

        <!-- breadcrumb -->
        @include('admin.layouts.menu._breadcrumb', ['page' => 'Data Periode', 'active' => 'Tambah Data'])
        <!-- breadcrumb -->

        <!-- row opened -->
        <div class="row row-sm">
            <div class="col-xl-12">
                @include('generals._validation')
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Tambah Data Periode</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.master-data.periode.store') }}" method="POST">
                            @csrf
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Nama Periode</label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <input class="form-control form-control-sm" name="nama_periode"
                                        placeholder="Masukkan Nama Periode" type="text">
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Keterangan</label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <textarea class="form-control form-control-sm" name="keterangan" placeholder="Masukkan Keterangan" type="text"></textarea>
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Tanggal Awal Penilaian</label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <input class="form-control form-control-sm" name="tgl_awal_penilaian"
                                        placeholder="Masukkan Tanggal Awal Penilaian" type="date">
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Tanggal Akhir Penilaian</label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <input class="form-control form-control-sm" name="tgl_akhir_penilaian"
                                        placeholder="Masukkan Tanggal Akhir Penilaian" type="date">
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label for="from-label mg-b-0">Tanggal Pengumuman</label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <input class="form-control form-control-sm" name="tgl_pengumuman"
                                        placeholder="Masukkan Tanggal Akhir Penilaian" type="date">
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
