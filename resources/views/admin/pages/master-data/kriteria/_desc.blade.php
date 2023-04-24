<div class="col-xl-12">
    <div class="card">
        <div class="card-header pb-0 pd-t-25">
            <div class="d-flex justify-content-between">
                <h4 class="card-title mg-b-0">Kriteria Sistem Pendukung Keputusan</h4>
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
