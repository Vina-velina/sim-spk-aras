<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FormatDateToIndonesia;
use App\Http\Controllers\Controller;
use App\Services\Debitur\DebiturDatatableServices;
use App\Services\Penilaian\PenilaianDatatableService;
use App\Services\Periode\PeriodeQueryServices;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    protected $debiturDatatableService;
    protected $periodeQueryService;
    public function __construct(
        DebiturDatatableServices $debiturDatatableService,
        PeriodeQueryServices $periodeQueryService
    ) {
        $this->debiturDatatableService = $debiturDatatableService;
        $this->periodeQueryService = $periodeQueryService;
    }


    public function index()
    {
        return view('admin.pages.penilaian.index');
    }


    public function detail(string $id)
    {
        $periode = $this->periodeQueryService->getOne($id);
        if (isset($periode)) {
            $periode->tgl_penilaian =  FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_awal_penilaian) . ' s/d ' .  FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_akhir_penilaian);
        }
        return view('admin.pages.penilaian.detail', compact('periode'));
    }




    public function datatable(Request $request)
    {
        return $this->debiturDatatableService->datatable($request);
    }
}
