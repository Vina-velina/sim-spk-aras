@extends('admin.layouts.app')

@section('tittle', 'Formulir Penilaian Periode')
@section('content')
    <!-- container -->
    <div class="container-fluid mg-t-20">

        <!-- breadcrumb -->
        @include('admin.layouts.menu._breadcrumb', [
            'page' => 'Data Penilaian Periode',
            'active' => 'Formulir Penilaian',
        ])
        <!-- breadcrumb -->

        <!-- row opened -->
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Penilaian Sistem Pendukung Keputusan</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <table>
                            <tbody>
                                <tr>
                                    <td>Nama Periode</td>
                                    <td>:</td>
                                    <td><b>{{ $periode->nama_periode }}</b></td>
                                </tr>
                                <tr>
                                    <td>Rentang Penilaian</td>
                                    <td>:</td>
                                    <td><b>{{ $periode->tgl_penilaian }}</b></td>
                                </tr>
                                <tr>
                                    <td>Status Penilaian</td>
                                    <td>:</td>
                                    <td>{!! $periode->status_penilaian !!}</td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <hr>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nama Debitur</td>
                                    <td>:</td>
                                    <td><b>{{ $debitur->nama }}</b></td>
                                </tr>
                                <tr>
                                    <td>Alamat Debitur</td>
                                    <td>:</td>
                                    <td><b>{{ $debitur->alamat }}</b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div>
            <div class="col-xl-12">
                @include('generals._validation')
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Formulir Penilaian Debitur</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ route('admin.penilaian.detail-penilaian.store-penilaian', [$periode->id, $debitur->id]) }}"
                            method="POST">
                            @csrf
                            {{-- <input type="hidden" name="id_kriteria" value="{{ $kriteriaPenilaian->id }}"> --}}
                            <p class="text-danger">* Wajib diisi</p>
                            @foreach ($kriteria as $item)
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-12">
                                        <label class="form-label mg-b-0">{{ $item->nama_kriteria }}
                                            <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-12 mg-t-5">
                                        @if ($item->subKriteriaPenilaian->count() > 0)
                                            <select name="penilaian[{{ $item->id }}]"
                                                class="form-control form-control-sm @error('penilaian.{$item->id}') is-invalid @enderror"
                                                id="">
                                                <option selected>-- Pilih Sub Kriteria --</option>
                                                @foreach ($item->subKriteriaPenilaian as $sub_kriteria)
                                                    <option value="{{ $sub_kriteria->nilai_sub_kriteria }}"
                                                        {{ $item->relasi_penilaian != null ? ($item->relasi_penilaian->nilai == $sub_kriteria->nilai_sub_kriteria ? 'selected' : '') : '' }}>
                                                        {{ $sub_kriteria->nama_sub_kriteria }}
                                                        (Nilai {{ $sub_kriteria->nilai_sub_kriteria }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input
                                                class="form-control form-control-sm @error('penilaian.{$item->id}') is-invalid @enderror"
                                                name="penilaian[{{ $item->id }}]"
                                                placeholder="Masukkan Nilai Dari Kriteria {{ $item->nama_kriteria }}"
                                                type="number"
                                                value="{{ $item->relasi_penilaian != null ? $item->relasi_penilaian->nilai : old('penilaian.{$item->id}') }}">
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            <button class="btn btn-sm btn-main-primary pd-x-30 mg-r-5 mg-t-5">Simpan</button>
                            <a href="{{ route('admin.penilaian.detail-penilaian', $periode->id) }}"
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
