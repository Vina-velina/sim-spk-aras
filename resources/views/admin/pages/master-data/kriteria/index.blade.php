@extends('admin.layouts.app')

@section('tittle', 'Kriteria')
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
                    url: "{{ route('admin.master-data.kategori.datatable.periode') }}",
                    data: function(d) {
                        d.status = "aktif";
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
                        data: "nama_periode",
                        name: 'nama_periode',
                        render: function(d) {
                            return d != null ? d : 'Tidak Ada'
                        }
                    },
                    {
                        data: "tgl_awal_penilaian",
                        name: 'tgl_awal_penilaian',
                        render: function(d) {
                            return d != null ? d : 'Tidak Ada'
                        }
                    },
                    {
                        data: "tgl_akhir_penilaian",
                        name: 'tgl_akhir_penilaian',
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
        @include('admin.layouts.menu._breadcrumb', ['page' => 'Data Kriteria', 'active' => 'Index'])
        <!-- breadcrumb -->

        <!-- row opened -->
        <div class="row row-sm">
            <!--div-->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Pilih Kategori</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-md-nowrap table-striped" id="basic-datatables">
                                <thead>
                                    <tr>
                                        <th class="wd-5p border-bottom-0">No</th>
                                        <th class="wd-15p border-bottom-0">#</th>
                                        <th class="wd-10p border-bottom-0">Nama Periode</th>
                                        <th class="wd-10p border-bottom-0">Tgl Awal Penilaian</th>
                                        <th class="wd-10p border-bottom-0">Tgl Akhir Penilaian</th>
                                    </tr>
                                </thead>

                                <body>

                                </body>
                            </table>
                        </div>
                    </div><!-- bd -->
                </div>
                <!--/div-->
            </div>
        </div>
    @endsection
