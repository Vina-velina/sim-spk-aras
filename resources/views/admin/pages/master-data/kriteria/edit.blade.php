@extends('admin.layouts.app')

@php
    $jatah = 100 - $total_bobot + $kriteria->bobot_kriteria;

    $nama_kriteria = '';

    foreach ($master_kriteria as $item) {
        if ($item->id == $kriteria->id_master_kriteria) {
            $nama_kriteria = $item->nama_kriteria;
        }
    }
@endphp

@section('tittle', 'Data Kriteria')

@section('otherJsPlugin')
    <!--Internal  Datatable js -->
    {{-- <script src="{{ asset('assets/js/table-data.js') }}"></script> --}}
    <script>
        var table = $('#basic-datatables');
        $(document).ready(function() {
            table.DataTable({
                // responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.master-data.kriteria.sub-datatable', $kriteria->id_periode) }}",
                    data: function(d) {
                        d.id_kriteria = "{{ $kriteria->id }}";
                        d.id_periode = "{{ $kriteria->id_periode }}";
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        orderable: false,
                        searchable: false,
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: "nama_sub_kriteria",
                        name: 'nama_sub_kriteria',
                        render: function(d) {
                            return d != null ? d : 'Tidak Ada'
                        }
                    },
                    {
                        data: "nilai_sub_kriteria",
                        name: 'nilai_sub_kriteria',
                        render: function(d) {
                            return d != null ? d : 'Tidak Ada'
                        }
                    },
                    {
                        data: "created_at",
                        name: 'created_at',
                        render: function(d) {
                            return d != null ? d : 'Tidak Ada'
                        }
                    },
                ],
                columnDefs: [
                    //Custom template data

                ],
            });

        });
    </script>
@endsection

@section('content')
    <!-- container -->
    <div class="container-fluid mg-t-20">

        <!-- breadcrumb -->
        @include('admin.layouts.menu._breadcrumb', [
            'page' => 'Data Kriteria',
            'active' => 'Edit Data Kriteria ' . $nama_kriteria,
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
                            <h4 class="card-title mg-b-0">Edit Data Kriteria
                                @if (strpos($periode->nama_periode, 'Periode') !== false)
                                    {{ $periode->nama_periode }}
                                @else
                                    {{ 'Periode ' . $periode->nama_periode }}
                                @endif
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.master-data.kriteria.update', [$periode->id, $kriteria->id]) }}"
                            method="POST">
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
                                        @foreach ($master_kriteria as $item)
                                            <option {{ $kriteria->id_master_kriteria == $item->id ? 'selected' : '' }}
                                                value="{{ $item->id }}">{{ $item->nama_kriteria }}</option>
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
                                        placeholder="Masukkan Keterangan" type="text">{!! old('keterangan') ? old('keterangan') : $kriteria->keterangan !!}</textarea>
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
                                        name="bobot_kriteria" placeholder="Masukkan Bobot Kriteria" type="number"
                                        min="1" max="{{ $jatah }}"
                                        value="{{ old('bobot_kriteria') ? old('bobot_kriteria') : $kriteria->bobot_kriteria }}">
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12">
                                    <label class="form-label mg-b-0">Status <span class="text-danger">*</span> </label>
                                </div>
                                <div class="col-md-12 mg-t-5">
                                    <select name="status"
                                        class="form-control form-control-sm @error('status') is-invalid @enderror"
                                        id="">
                                        @if ($kriteria->status == 'aktif')
                                            <option value="aktif" selected>Aktif</option>
                                            <option value="nonaktif">Non Aktif</option>
                                        @else
                                            <option value="aktif">Aktif</option>
                                            <option value="nonaktif" selected>Non Aktif</option>
                                        @endif
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
            <!--div-->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Data Sub Kriteria
                                @if (strpos($periode->nama_periode, 'Periode') !== false)
                                    {{ $periode->nama_periode }}
                                @else
                                    {{ 'Periode ' . $periode->nama_periode }}
                                @endif
                            </h4>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="btn-icon-list">
                                <a
                                    href="{{ route('admin.master-data.sub-kriteria.create', [$periode->id, $kriteria->id]) }}">
                                    <button type="button" class="btn btn-sm btn-primary btn-icon"><i
                                            class="typcn typcn-plus"></i>
                                        Tambah</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-md-nowrap table-striped" id="basic-datatables">
                                <thead>
                                    <tr>
                                        <th class="wd-5p border-bottom-0">No</th>
                                        <th class="wd-15p border-bottom-0">#</th>
                                        <th class="wd-10p border-bottom-0">Nama Sub Kriteria</th>
                                        <th class="wd-10p border-bottom-0">Nilai Sub Kriteria</th>
                                        <th class="wd-10p border-bottom-0">Dibuat Pada</th>
                                    </tr>
                                </thead>

                                <body>

                                </body>
                            </table>
                        </div>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div>
        </div>
    </div>

@endsection
