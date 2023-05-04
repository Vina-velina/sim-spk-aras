@extends('admin.layouts.app')

@section('tittle', 'Data Rekomendasi Periode')
@section('otherJsPlugin')
    <script>
        var table = $('#basic-datatables');
        var table2 = $('#basic-datatables-debitur');
        $(document).ready(function() {
            table.DataTable({
                // responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.rekapan-spk.datatable.rekomendasi') }}",
                    data: function(d) {
                        d.id_periode = "{{ $periode->id }}";
                    }
                },
                columns: [{
                        data: "ranking",
                        name: "ranking",
                        render: function(d) {
                            return d != null ? d : 'Tidak Ada'
                        }
                    },
                    {
                        data: "nama_debitur",
                        name: "nama_debitur",
                        render: function(d) {
                            return d != null ? d : 'Tidak Ada'
                        }
                    },
                    {
                        data: "alamat_debitur",
                        name: "alamat_debitur",
                        render: function(d) {
                            return d != null ? d : 'Tidak Ada'
                        }
                    },

                    {
                        data: "nilai_aras",
                        name: "nilai_aras",
                        render: function(d) {
                            return d != null ? d : 'Tidak Ada'
                        }
                    },
                ],
                columnDefs: [
                    //Custom template data

                ],
            });


            table2.DataTable({
                // responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.rekapan-spk.datatable.terpilih') }}",
                    data: function(d) {
                        d.id_periode = "{{ $periode->id }}";
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
                        data: "nama_debitur",
                        name: "nama_debitur",
                        render: function(d) {
                            return d != null ? d : 'Tidak Ada'
                        }
                    },
                    {
                        data: "alamat_debitur",
                        name: "alamat_debitur",
                        render: function(d) {
                            return d != null ? d : 'Tidak Ada'
                        }
                    },
                    {
                        data: "ranking",
                        name: "ranking",
                        render: function(d) {
                            return d != null ? d : 'Tidak Ada'
                        }
                    },
                    {
                        data: "nilai_aras",
                        name: "nilai_aras",
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

        const addNilaiAlternatif = (button) => {
            const id_debitur = $(button).data('id_debitur');
        }
    </script>
@endsection
@section('content')
    <!-- container -->
    <div class="container-fluid mg-t-20">

        <!-- breadcrumb -->
        @include('admin.layouts.menu._breadcrumb', [
            'page' => 'Data Rekomendasi Periode',
            'active' => 'Index',
        ])
        <!-- breadcrumb -->

        <!-- row opened -->
        <div class="row row-sm">
            <!--div-->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Rekomendasi Sistem Pendukung Keputusan</h4>
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
                            </tbody>
                        </table>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Data Rekomendasi ARAS</h4>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="btn-icon-list">
                                <a href="javascript:void(0);" data-target="#modalPerhitunganAras" data-toggle="modal"
                                    class="btn btn-sm btn-info btn-icon"><i class="typcn typcn-eye"></i>
                                    Perhitungan
                                </a>
                            </div>
                            <form action="{{ route('admin.rekapan-spk.detail.export-rekomendasi', $periode->id) }}"
                                method="post">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-warning btn-icon ml-1"><i
                                        class="typcn typcn-download"></i>
                                    Export
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-md-nowrap table-striped" id="basic-datatables">
                                <thead>
                                    <tr>
                                        <th class="wd-5p border-bottom-0">Ranking</th>
                                        <th class="wd-15p border-bottom-0">Nama Debitur</th>
                                        <th class="wd-15p border-bottom-0">Alamat Debitur</th>
                                        <th class="wd-15p border-bottom-0">Nilai Aras</th>
                                    </tr>
                                </thead>

                                <body>

                                </body>
                            </table>
                        </div>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div>
            <!--/div-->
            <div class="col-xl-12">
                @include('generals._validation')
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Data Debitur Terpilih</h4>
                        </div>
                        <div class="d-flex justify-content-end">
                            @if (Auth::user()->role_user == 'super_admin')
                                @if ($periode->status == 'aktif')
                                    <div class="btn-icon-list">
                                        <a href="javascript:void(0);" data-target="#modalTambahDebiturTerpilih"
                                            data-toggle="modal" class="btn btn-sm btn-primary btn-icon"><i
                                                class="typcn typcn-plus"></i>
                                            Tambah
                                        </a>
                                    </div>

                                    <form action="{{ route('admin.rekapan-spk.detail.publish-terpilih', $periode->id) }}"
                                        id="publish-button" method="post">
                                        @csrf
                                        <a href="javascript:void(0);" onclick="alertConfirmPublish()"
                                            class="btn btn-sm btn-success btn-icon ml-1"><i class="typcn typcn-upload"></i>
                                            Publish
                                        </a>
                                    </form>
                                @endif
                            @endif
                            @if ($periode->status == 'nonaktif')
                                <form action="{{ route('admin.rekapan-spk.detail.export-terpilih', $periode->id) }}"
                                    method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning btn-icon ml-1"><i
                                            class="typcn typcn-download"></i>
                                        Export
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-md-nowrap table-striped" id="basic-datatables-debitur">
                                <thead>
                                    <tr>
                                        <th class="wd-5p border-bottom-0">No</th>
                                        <th class="wd-5p border-bottom-0">#</th>
                                        <th class="wd-15p border-bottom-0">Nama Debitur</th>
                                        <th class="wd-15p border-bottom-0">Alamat Debitur</th>
                                        <th class="wd-15p border-bottom-0">Ranking</th>
                                        <th class="wd-15p border-bottom-0">Nilai Aras</th>
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
    @include('admin.pages.rekapan._modal_tambah_debitur_terpilih')
    @include('admin.pages.rekapan._modal_perhitungan')
@endsection
