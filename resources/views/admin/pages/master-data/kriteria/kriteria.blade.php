@extends('admin.layouts.app')
{{-- @dd(route('admin.master-data.kriteria.datatable')) --}}
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
                    url: "{{ route('admin.master-data.kriteria.datatable', $periode->id) }}",
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
                        data: "jenis",
                        name: 'jenis',
                        render: function(d) {
                            return d != null ? d : 'Tidak Ada'
                        }
                    },
                    {
                        data: "bobot_kriteria",
                        name: 'bobot_kriteria',
                        render: function(d) {
                            return d != null ? d + '%' : 'Tidak Ada'
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
                        // refresh page
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
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
        @include('admin.layouts.menu._breadcrumb', [
            'page' => 'Data Kriteria',
            'active' => 'Kriteria ' . $periode->nama_periode,
        ])
        <!-- breadcrumb -->
        @include('admin.pages.master-data.kriteria._alert')

        <!-- row opened -->
        <div class="row row-sm">
            <!--div-->
            @include('admin.pages.master-data.kriteria._desc')
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0 pd-t-25">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Data Kriteria
                                @if (strpos($periode->nama_periode, 'Periode') !== false)
                                    {{ $periode->nama_periode }}
                                @else
                                    {{ 'Periode ' . $periode->nama_periode }}
                                @endif
                            </h4>


                        </div>
                        <div class="d-flex justify-content-end">
                            @if ($total_bobot < 100)
                                <div class="btn-icon-list">
                                    <a href="{{ route('admin.master-data.kriteria.create', $periode->id) }}">
                                        <button type="button" class="btn btn-sm btn-primary btn-icon"><i
                                                class="typcn typcn-plus"></i>
                                            Tambah</button>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-md-nowrap table-striped" id="basic-datatables">
                                <thead>
                                    <tr>
                                        <th class="wd-5p border-bottom-0">No</th>
                                        <th class="wd-5p border-bottom-0">#</th>
                                        <th class="wd-10p border-bottom-0">Nama Kriteria</th>
                                        <th class="wd-10p border-bottom-0">Keterangan</th>
                                        <th class="wd-10p border-bottom-0">Jenis Kriteria</th>
                                        <th class="wd-10p border-bottom-0">Bobot Kriteria</th>
                                        <th class="wd-10p border-bottom-0">Status</th>
                                    </tr>
                                </thead>

                                <body>

                                </body>
                            </table>
                        </div>
                    </div><!-- bd -->
                    {{-- tombol kembali --}}
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            <div class="btn-icon-list">
                                <a href="{{ route('admin.master-data.kriteria.index') }}">
                                    <button type="button" class="btn btn-sm btn-primary btn-icon"><i
                                            class="typcn typcn-arrow-back-outline"></i>
                                        Kembali</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div><!-- bd -->
            </div>
            <!--/div-->
        </div>
    </div>
@endsection
