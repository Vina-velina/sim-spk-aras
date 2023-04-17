@extends('admin.layouts.app')

@section('tittle', 'Kriteria')
@section('otherJsPlugin')
    <!--Internal  Datatable js -->
    {{-- <script src="{{ asset('assets/js/table-data.js') }}"></script> --}}
    <script>
        var table = $('#basic-datatables');
        $(document).ready(function() {
            table.DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.master-data.kategori.datatable') }}",
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
                        data: "nama_kriteria",
                        name: 'nama_kriteria',
                        render: function(d) {
                            return d != null ? d : 'Tidak Ada'
                        }
                    },
                    {
                        data: "keterangan",
                        name: 'keterangan',
                        render: function(d) {
                            return d != null ? d : 'Tidak Ada'
                        }
                    },
                    {
                        data: "bobot_kriteria",
                        name: 'bobot_kriteria',
                        render: function(d) {
                            return d != null ? d : 'Tidak Ada'
                        }
                    },
                    {
                        data: "status",
                        orderable: false,
                        searchable: false,
                        name: 'status',
                    },


                ],
                columnDefs: [
                    //Custom template data

                ],
            });

        });

        const changeStatusKriteria = (button) => {
            const url_update = $(button).data('url_update');
            $.ajax({
                url: url_update,
                type: "GET",
                success: function(response) {
                    // console.log(response);
                    if (response.success) {
                        alertSuccess(response.message);
                    } else {
                        alertGagal(response.message);
                    }
                    table.DataTable().ajax.reload();
                }
            });
        }
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
                            <h4 class="card-title mg-b-0">Data Kriteria</h4>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="btn-icon-list">
                                <a href="{{ route('admin.master-data.kategori.create') }}">
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
                                        <th class="wd-10p border-bottom-0">Nama Kriteria</th>
                                        <th class="wd-10p border-bottom-0">Keterangan</th>
                                        <th class="wd-10p border-bottom-0">bobot_kriteria</th>
                                        <th class="wd-10p border-bottom-0">Status</th>
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
@endsection
