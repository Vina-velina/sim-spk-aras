@extends('admin.layouts.app')

@section('tittle', 'Data Penilaian')
@section('otherJsPlugin')
    <script>
        var table = $('#basic-datatables');
        $(document).ready(function() {
            table.DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.master-data.debitur.datatable') }}",
                    data: function(d) {
                        d.id_aktif = "aktif";
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
                        data: 'action_penilaian',
                        name: 'action_penilaian',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: "nama",
                        name: "nama",
                        render: function(d) {
                            return d != null ? d : 'Tidak Ada'
                        }
                    },
                    {
                        data: "alamat",
                        name: "alamat",
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
        @include('admin.layouts.menu._breadcrumb', ['page' => 'Data penilaian', 'active' => 'Index'])
        <!-- breadcrumb -->

        <!-- row opened -->
        <div class="row row-sm">
            <!--div-->
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
                            </tbody>
                        </table>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Data Alternatif Tersedia</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-md-nowrap table-striped" id="basic-datatables">
                                <thead>
                                    <tr>
                                        <th class="wd-5p border-bottom-0">No</th>
                                        <th class="wd-15p border-bottom-0">#</th>
                                        <th class="wd-15p border-bottom-0">Nama Debitur</th>
                                        <th class="wd-15p border-bottom-0">Alamat Debitur</th>
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
        </div>
    </div>
    @include('admin.pages.master-data.periode._modal_detail')
    {{-- @include('admin.pages.master-data.periode._modal_import') --}}
@endsection
