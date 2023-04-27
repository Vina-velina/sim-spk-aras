<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Debitur\DebiturQueryServices;
use App\Services\MasterKriteria\MasterKriteriaQueryServices;
use App\Services\Periode\PeriodeQueryServices;

class HomeController extends Controller
{
    protected $periodeQueryService;

    protected $masterKriteriaQueryService;

    protected $debiturQueryService;

    public function __construct(
        PeriodeQueryServices $periodeQueryService,
        MasterKriteriaQueryServices $masterKriteriaQueryService,
        DebiturQueryServices $debiturQueryService
    ) {
        $this->periodeQueryService = $periodeQueryService;
        $this->masterKriteriaQueryService = $masterKriteriaQueryService;
        $this->debiturQueryService = $debiturQueryService;
    }

    public function index()
    {
        $total_periode = $this->periodeQueryService->getTotalPeriode();
        $total_masterKriteria = $this->masterKriteriaQueryService->getTotalMasterKriteria();
        $total_debitur = $this->debiturQueryService->getTotaldebitur();

        return view('admin.pages.dashboard.index', compact('total_masterKriteria', 'total_debitur', 'total_periode'));
    }
}
