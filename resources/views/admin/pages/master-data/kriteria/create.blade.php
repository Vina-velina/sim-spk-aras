@extends('admin.layouts.app')

@php
    $jatah = 100 - $total_bobot;
@endphp

@section('tittle', 'Data Kriteria')
@section('content')
    <!-- container -->
    <div class="container-fluid mg-t-20">

        <!-- breadcrumb -->
        @include('admin.layouts.menu._breadcrumb', [
            'page' => 'Data Kriteria',
            'active' => 'Tambah Data Kriteria',
        ])
        <!-- breadcrumb -->
        @include('admin.pages.master-data.kriteria._alert')

        <!-- row opened -->
        <div class="row row-sm">
            @include('admin.pages.master-data.kriteria._desc')
            <div class="col-xl-12">
                @include('generals._validation')
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Tambah Data Kriteria
                                @if (strpos($periode->nama_periode, 'Periode') !== false)
                                    {{ $periode->nama_periode }}
                                @else
                                    {{ 'Periode ' . $periode->nama_periode }}
                                @endif
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.master-data.kriteria.store', $periode->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_periode" value="{{ $periode->id }}">
                            <p class="text-danger">* Wajib diisi</p>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Nama Kriteria <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <select name="id_master_kriteria"
                                        class="form-control form-control-sm @error('id_master_kriteria') is-invalid @enderror"
                                        id="">
                                        <option selected>-- Pilih Kriteria --</option>
                                        @foreach ($master_kriteria as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_kriteria }}</option>
                                        @endforeach
                                    </select>
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
                                    <label class="form-label mg-b-0">Bobot Kriteria (%) <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <input
                                        class="form-control form-control-sm @error('bobot_kriteria') is-invalid @enderror"
                                        name="bobot_kriteria" placeholder="Masukkan Bobot Kriteria" min="1"
                                        max="{{ $jatah }}" type="number" value="{{ old('bobot_kriteria') }}">
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Status <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <select name="status"
                                        class="form-control form-control-sm @error('status') is-invalid @enderror"
                                        id="">
                                        <option value="aktif" selected>Aktif</option>
                                        <option value="nonaktif">Non Aktif</option>
                                    </select>
                                </div>
                            </div>
                            <button class="btn btn-sm btn-main-primary pd-x-30 mg-r-5 mg-t-5">Simpan</button>
                            <a href="{{ route('admin.master-data.kriteria.kriteria', $periode->id) }}"
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
