@if ($total_bobot == 100)
    <div class="alert alert-success d-flex align-items-center" role="alert">
        <div class="alert-icon tx-24">
            <i class="fa fa-check-circle" aria-hidden="true"></i>
        </div>
        <div class="mx-3">
            <h5 class="mg-b-0">Bobot Kriteria Sudah Mencapai 100%</h5>
        </div>
    </div>
@else
    <div class="alert alert-warning d-flex align-items-center" role="alert">
        <div class="alert-icon tx-24">
            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
        </div>
        <div class="mx-3">
            <h5 class="mg-b-0">Total Bobot Kriteria {{ $total_bobot }}%</h5>
            <p class="mg-b-0">Silahkan tambahkan bobot kriteria agar mencapai 100%</p>
        </div>
    </div>
@endif
