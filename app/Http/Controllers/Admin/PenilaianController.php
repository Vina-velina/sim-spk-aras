<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FormatDateToIndonesia;
use App\Http\Controllers\Controller;
use App\Services\Debitur\DebiturDatatableServices;
use App\Services\Debitur\DebiturQueryServices;
use App\Services\Kriteria\KriteriaQueryServices;
use App\Services\Penilaian\PenilaianDatatableService;
use App\Services\Periode\PeriodeQueryServices;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    protected $debiturDatatableService;

    protected $periodeQueryService;

    protected $debiturQueryService;

    protected $kriteriaQueryService;

    public function __construct(
        DebiturDatatableServices $debiturDatatableService,
        PeriodeQueryServices $periodeQueryService,
        DebiturQueryServices $debiturQueryService,
        KriteriaQueryServices $kriteriaQueryService
    ) {
        $this->debiturDatatableService = $debiturDatatableService;
        $this->periodeQueryService = $periodeQueryService;
        $this->debiturQueryService = $debiturQueryService;
        $this->kriteriaQueryService = $kriteriaQueryService;
    }


    public function index()
    {
        return view('admin.pages.penilaian.index');
    }


    public function detail(string $id)
    {
        $periode = $this->periodeQueryService->getOneWhereAktif($id);
        $periode->tgl_penilaian =  FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_awal_penilaian) . ' s/d ' .  FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_akhir_penilaian);
        return view('admin.pages.penilaian.detail', compact('periode'));
    }

    public function createOrEditPenilaian(string $id_periode, string $id_debitur)
    {
        $periode = $this->periodeQueryService->getOneWhereAktif($id_periode);
        $periode->tgl_penilaian =  FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_awal_penilaian) . ' s/d ' .  FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_akhir_penilaian);
        $debitur = $this->debiturQueryService->getOneWhereAktif($id_debitur);
        $kriteria = $this->kriteriaQueryService->getByIdPeriode($id_periode);
        $kriteria->map(function ($item) use ($periode, $debitur) {
            $item->relasi_penilaian = $item->penilaian
                ->where('id_periode', $periode->id)
                ->where('id_debitur', $debitur->id)
                ->first();
            return $item;
        });
        return view('admin.pages.penilaian.createOrEdit', compact('periode', 'debitur', 'kriteria'));
    }
}
