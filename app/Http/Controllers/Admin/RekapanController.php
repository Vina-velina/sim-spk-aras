<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ArasQueryHelpers;
use App\Helpers\FormatDateToIndonesia;
use App\Http\Controllers\Controller;
use App\Services\HasilRekapan\HasilRekapanCommandService;
use App\Services\Periode\PeriodeQueryServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class RekapanController extends Controller
{
    protected $periodeQueryService;
    protected $hasilRekapanCommandService;
    public function __construct(PeriodeQueryServices $periodeQueryService, HasilRekapanCommandService $hasilRekapanCommandService)
    {
        $this->hasilRekapanCommandService = $hasilRekapanCommandService;
        $this->periodeQueryService = $periodeQueryService;
    }
    public function index()
    {
        return view('admin.pages.rekapan.index');
    }

    public function detail(string $id)
    {
        try {
            $periode = $this->periodeQueryService->getOne($id);
            $periode->tgl_penilaian = FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_awal_penilaian) . ' s/d ' . FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_akhir_penilaian);
            DB::beginTransaction();
            $deleteRekomendasi = $this->hasilRekapanCommandService->deleteRekomendasi($periode->id);
            $dssData = ArasQueryHelpers::dss($periode->id);
            $orderData = $this->hasilRekapanCommandService->updateOrder($periode->id);
            DB::commit();
            return view('admin.pages.rekapan.hasil', compact('periode', 'orderData', 'dssData'));
        } catch (Throwable $th) {
            DB::rollBack();
            return to_route('admin.rekapan-spk.index')->with('error', $th->getMessage());
        }
    }
}
