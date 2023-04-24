@extends('admin.layouts.app')

@section('tittle', 'Master Kriteria')

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
                    url: "{{ route('admin.master-data.master-kriteria.datatable') }}",
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
                        data: "created_at",
                        name: 'created_at',
                        render: function(d) {
                            return d != null ? d : 'Tidak Ada'
                        }
                    },
                    {
                        data: "updated_at",
                        name: 'updated_at',
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

        const detailMasterKriteria = (button) => {
            const url_detail = $(button).data('url_detail');
            $.ajax({
                url: url_detail,
                type: "GET",
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        const data = response.data;
                        const created_at = response.created_at;
                        const updated_at = response.updated_at;
                        const form = $('#detailMasterKriteria');
                        form.find('input[name=nama_kriteria]').val(data.nama_kriteria);
                        form.find('textarea[name=keterangan]').val(data.keterangan);
                        form.find('input[name=created_at]').val(created_at);
                        form.find('input[name=updated_at]').val(updated_at);
                        $('#modalDetailMasterKriteria').modal('show');
                    }
                }
            });
        }
    </script>
@endsection

@section('content')
    <!-- container -->
    <div class="container-fluid mg-t-20">

        <!-- breadcrumb -->
        @include('admin.layouts.menu._breadcrumb', ['page' => 'Data Master Kriteria', 'active' => 'Index'])
        <!-- breadcrumb -->

        <!-- row opened -->
        <div class="row row-sm">
            <!--div-->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Data Master Kriteria</h4>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="btn-icon-list">
                                <a href="{{ route('admin.master-data.master-kriteria.create') }}">
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
                                        <th class="wd-10p border-bottom-0">Dibuat Pada</th>
                                        <th class="wd-10p border-bottom-0">Diperbaharui Pada</th>
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
    @include('admin.pages.master-data.master-kriteria._modal_detail')
@endsection
