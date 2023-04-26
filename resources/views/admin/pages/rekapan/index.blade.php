@extends('admin.layouts.app')

@section('tittle', 'Data Rekapan SPK')
@section('otherJsPlugin')
    <!--Internal  Datatable js -->
    {{-- <script src="{{ asset('assets/js/table-data.js') }}"></script> --}}
    <script>
        var table = $('#basic-datatables');
        $(document).ready(function() {
            table.DataTable({
                // responsive: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.master-data.periode.datatable') }}",
                },
                columns: [{
                        data: "DT_RowIndex",
                        orderable: false,
                        searchable: false,
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'action_rekapan',
                        name: 'action_rekapan',
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
                        data: "tgl_penilaian",
                        name: 'tgl_penilaian',
                        render: function(d) {
                            return d != null ? d : 'Tidak Ada'
                        }
                    },
                    {
                        data: "status_penilaian",
                        name: 'status_penilaian',
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
        @include('admin.layouts.menu._breadcrumb', ['page' => 'Data Rekapan SPK', 'active' => 'Index'])
        <!-- breadcrumb -->

        <!-- row opened -->
        <div class="row row-sm">
            <!--div-->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Data rekapan SPK berdasarkan periode</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-md-nowrap table-striped" id="basic-datatables">
                                <thead>
                                    <tr>
                                        <th class="wd-5p border-bottom-0">No</th>
                                        <th class="wd-5p border-bottom-0">#</th>
                                        <th class="wd-15p border-bottom-0">Nama Periode</th>
                                        <th class="wd-15p border-bottom-0">Tgl Penilaian</th>
                                        <th class="wd-15p border-bottom-0">Status Penilaian</th>
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
