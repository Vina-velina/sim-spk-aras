<?php

namespace App\Services\Penilaian;

use App\Http\Requests\Penilaian\PenilaianStoreUpdateRequest;
use App\Models\KriteriaPenilaian;
use App\Models\Penilaian;
use App\Services\Debitur\DebiturQueryServices;
use App\Services\Periode\PeriodeQueryServices;
use Carbon\Carbon;

class PenilaianCommandService
{
    protected $periodeQueryService;

    protected $debiturQueryService;

    public function __construct(
        PeriodeQueryServices $periodeQueryService,
        DebiturQueryServices $debiturQueryService,
    ) {
        $this->periodeQueryService = $periodeQueryService;
        $this->debiturQueryService = $debiturQueryService;
    }

    public function storeOrUpdate(PenilaianStoreUpdateRequest $request, string $id_periode, string $id_debitur)
    {
        $request->validated();
        $periode = $this->periodeQueryService->getOneWhereAktif($id_periode);
        $debitur = $this->debiturQueryService->getOneWhereAktif($id_debitur);

        if (Carbon::now()->format('Y-m-d H:i:s') < $periode->tgl_awal_penilaian || Carbon::now()->format('Y-m-d H:i:s') > $periode->tgl_akhir_penilaian) {
            throw new \Exception('Periode Penilaian Debitur Telah Usai');
        }

        Penilaian::where('id_periode', $id_periode)->where('id_debitur', $id_debitur)->delete();

        $penilaian = [];
        foreach ($request->penilaian as $kriteriaId => $nilai) {
            $kriteria = KriteriaPenilaian::find($kriteriaId);
            $penilaian = new Penilaian();
            $penilaian->id_debitur = $debitur->id;
            $penilaian->id_periode = $periode->id;
            $penilaian->id_kriteria = $kriteria->id;
            $penilaian->nilai = $nilai;
            $penilaian->save();
        }

        return $penilaian;
    }
}
