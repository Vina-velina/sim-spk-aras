@extends('admin.layouts.app')

@section('tittle', 'Data Debitur')
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
                    url: "{{ route('admin.master-data.debitur.datatable') }}",
                    data: function(d) {
                        d.is_aktif = $('#statusDebiturFilter').val();
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
                        data: "nama",
                        name: 'nama',
                        render: function(d) {
                            return d != null ? d : 'Tidak Ada'
                        }
                    },
                    {
                        data: "alamat",
                        name: 'alamat',
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

        const filterDatatable = () => {
            table.DataTable().ajax.reload();
            $('#statusAktifExport').val($('#statusDebiturFilter').val());
        }
        const changeStatusDebitur = (button) => {
            const url_update = $(button).data('url_update');
            $.ajax({
                url: url_update,
                type: "GET",
                success: function(response) {
                    if (response.success) {
                        alertSuccess(response.message);
                    } else {
                        alertGagal(response.message);
                    }
                    table.DataTable().ajax.reload();
                }
            });
        }

        const detailDebitur = (button) => {
            const url_detail = $(button).data('url_detail');
            $.ajax({
                url: url_detail,
                type: "GET",
                success: function(response) {
                    if (response.success) {
                        const data = response.data;
                        const form = $('#detailDebitur');
                        form.find('input[name=nama_debitur]').val(data.nama);
                        form.find('textarea[name=alamat_debitur]').val(data.alamat);
                        form.find('input[name=pekerjaan_debitur]').val(data.pekerjaan);
                        form.find('input[name=nomor_telepon]').val(data.no_telp);
                        form.find('input[name=nomor_ktp]').val(data.no_ktp);
                        form.find(`select[name=status] option[value="${data.status}"]`).attr('selected',
                            true);
                        if (data.foto != null) {
                            $('#fotoDebitur').attr('src', data.link_foto)
                        } else {
                            $('#fotoDebitur').attr('src',
                                'https://ui-avatars.com/api/?name=' + data.nama +
                                '&background=5174ff&color=fff'
                            );

                        }
                        $('#modalDetailDebitur').modal('show');
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
        @include('admin.layouts.menu._breadcrumb', ['page' => 'Data Debitur', 'active' => 'Index'])
        <!-- breadcrumb -->

        <!-- row opened -->
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Filter Data</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-xs align-items-center mg-b-20">
                            <div class="col-md-10 col-12 mg-t-5">
                                <label class="form-label">Status Debitur</label>
                                <select type="text" class="form-control form-control-sm" id="statusDebiturFilter">
                                    <option value=""> -- Pilih Status --</option>
                                    <option value="semua">Semua Status</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-12 mg-t-5">
                                <label class="form-label pb-4"></label>
                                <button class="btn btn-sm btn-secondary btn-block pt-2" onclick="filterDatatable()"><i
                                        class="typcn typcn-filter"></i>
                                    Filter</button>
                            </div>
                        </div>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div>
            <!--div-->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Data Debitur</h4>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="btn-icon-list">
                                <form action="{{ route('admin.master-data.debitur.export') }}" method="get">
                                    <a href="{{ route('admin.master-data.debitur.create') }}">
                                        <button type="button" class="btn btn-sm btn-primary btn-icon"><i
                                                class="typcn typcn-plus"></i>
                                            Tambah</button>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-info btn-icon"
                                        data-target="#modalImportDebitur" data-toggle="modal"><i
                                            class="typcn typcn-document-add"></i>
                                        Import</button>
                                    <input type="hidden" name="status_aktif" id="statusAktifExport" value="semua">
                                    <button class="btn btn-sm btn-success btn-icon" type="submit"><i
                                            class="typcn typcn-document-text"></i>
                                        Export</button>
                                </form>
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
                                        <th class="wd-10p border-bottom-0">Nama Debitur</th>
                                        <th class="wd-10p border-bottom-0">Alamat Debitur</th>
                                        <th class="wd-10p border-bottom-0">Status Debitur</th>
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
    @include('admin.pages.master-data.debitur._modal_detail')
    @include('admin.pages.master-data.debitur._modal_import')
@endsection
