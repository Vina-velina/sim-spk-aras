@extends('admin.layouts.app')

@section('tittle', 'Data Periode')
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
                    url: "{{ route('admin.master-data.periode.datatable') }}",
                    // data: function(d) {
                    //     d.status = $('#statusPeriodeFilter').val();
                    // }
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

                    // {
                    //     data: "status",
                    //     orderable: false,
                    //     searchable: false,
                    //     name: 'status',
                    // },


                ],
                columnDefs: [
                    //Custom template data

                ],
            });

        });

        const changeStatusPeriode = (button) => {
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

        // const filterDatatable = () => {
        //     table.DataTable().ajax.reload();
        // }

        const detailPeriode = (button) => {
            const url_detail = $(button).data('url_detail');
            $.ajax({
                url: url_detail,
                type: "GET",
                success: function(response) {
                    // console.log(response);
                    if (response.success) {
                        const data = response.data;
                        const form = $('#detailPeriode');
                        form.find('input[name=nama_periode]').val(data.nama_periode);
                        form.find('textarea[name=keterangan]').val(data.keterangan);
                        form.find('input[name=tgl_awal_penilaian]').val(data.tgl_awal_penilaian);
                        form.find('input[name=tgl_akhir_penilaian]').val(data.tgl_akhir_penilaian);
                        form.find('input[name=tgl_pengumuman]').val(data.tgl_pengumuman);
                        form.find(`select[name=status] option[value="${data.status}"]`).attr('selected',
                            true);
                        form.find('#userPeriodeDetail').empty();
                        form.find('#userPeriodeDetail').append(response.userPeriode);
                        // if (data.foto != null) {
                        //     $('#fotoDebitur').attr('src', data.link_foto)
                        // } else {
                        //     $('#fotoDebitur').attr('src',
                        //         'https://ui-avatars.com/api/?name=' + data.nama +
                        //         '&background=5174ff&color=fff'
                        //     );

                        // }
                        $('#modalDetailPeriode').modal('show');
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
        @include('admin.layouts.menu._breadcrumb', ['page' => 'Data periode', 'active' => 'Index'])
        <!-- breadcrumb -->

        <!-- row opened -->
        <div class="row row-sm">
            <!--div-->
            {{-- <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Filter Data</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-xs align-items-center mg-b-20">
                            <div class="col-md-10 col-12 mg-t-5">
                                <label class="form-label">Status Periode</label>
                                <select type="text" class="form-control form-control-sm" id="statusPeriodeFilter">
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
            </div> --}}

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Data periode</h4>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="btn-icon-list">
                                <a href="{{ route('admin.master-data.periode.create') }}">
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
                                        <th class="wd-10p border-bottom-0">Nama Periode</th>
                                        <th class="wd-10p border-bottom-0">Tgl Awal Penilaian</th>
                                        <th class="wd-10p border-bottom-0">Tgl Akhir Penilaian</th>
                                        {{-- <th class="wd-10p border-bottom-0">Status</th> --}}
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
