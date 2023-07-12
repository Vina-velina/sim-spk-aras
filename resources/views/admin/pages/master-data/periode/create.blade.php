@extends('admin.layouts.app')

@section('tittle', 'Data Periode')
@section('otherJsPlugin')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
@section('otherCssPlugin')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('otherJsQuery')
    <script>
        $(document).ready(function() {
            $('#debiturSelect2').select2();
        });

        const selectAll = () => {
            $('#debiturSelect2 option').prop('selected', true);
            $('#debiturSelect2').trigger('change');
        };
    </script>
@endsection
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
                            <p class="text-danger">* Wajib diisi</p>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Nama Periode <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <input class="form-control form-control-sm @error('nama_periode') is-invalid @enderror"
                                        name="nama_periode" placeholder="Masukkan Nama Periode" type="text"
                                        value="{{ old('nama_periode') }}">
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Keterangan</label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <textarea class="form-control form-control-sm @error('keterangan') is-invalid @enderror" name="keterangan"
                                        placeholder="Masukkan Keterangan" type="text">{!! old('keterangan') !!}</textarea>
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
                                        type="datetime-local" value="{{ old('tgl_awal_penilaian') }}">
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
                                        type="datetime-local" value="{{ old('tgl_akhir_penilaian') }}">
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Debitur Yang Terlibat <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-10 mg-t-5">
                                    <select name="user_periode[]" multiple
                                        class="form-control form-control-sm @error('user_periode') is-invalid @enderror"
                                        id="debiturSelect2">
                                        @foreach ($debiturs as $debitur)
                                            <option value="{{ $debitur->id }}">{{ $debitur->nama }} -
                                                {{ $debitur->alamat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 mg-t-5">
                                    <button class="btn col-12 btn-primary" type="button" id="button-hak-akses"
                                        onclick="selectAll()">
                                        Pilih Semua
                                    </button>
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
