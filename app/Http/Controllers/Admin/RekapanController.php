<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ArasQueryHelpers;
use App\Helpers\FormatDateToIndonesia;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rekapan\StoreDebiturTerpilihRequest;
use App\Services\HasilRekapan\HasilRekapanCommandService;
use App\Services\HasilRekapan\HasilRekapanDatatableService;
use App\Services\HasilRekapan\HasilRekapanQueryService;
use App\Services\Periode\PeriodeQueryServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class RekapanController extends Controller
{
    protected $periodeQueryService;

    protected $hasilRekapanCommandService;

    protected $hasilRekapanQueryService;

    protected $hasilRekapanDatatableService;

    public function __construct(
        PeriodeQueryServices $periodeQueryService,
        HasilRekapanCommandService $hasilRekapanCommandService,
        HasilRekapanDatatableService $hasilRekapanDatatableService,
        HasilRekapanQueryService $hasilRekapanQueryService
    ) {
        $this->hasilRekapanCommandService = $hasilRekapanCommandService;
        $this->periodeQueryService = $periodeQueryService;
        $this->hasilRekapanDatatableService = $hasilRekapanDatatableService;
        $this->hasilRekapanQueryService = $hasilRekapanQueryService;
    }

    public function index()
    {
        return view('admin.pages.rekapan.index');
    }

    public function detail(string $id)
    {
        try {
            $periode = $this->periodeQueryService->getOne($id);
            $periode->tgl_penilaian = FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_awal_penilaian).' s/d '.FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_akhir_penilaian);
            $periode->status_penilaian = self::_getStatusPenilaian($periode->tgl_awal_penilaian, $periode->tgl_akhir_penilaian);

            DB::beginTransaction();
            $deleteRekomendasi = $this->hasilRekapanCommandService->deleteRekomendasi($periode->id);
            $dssData = ArasQueryHelpers::dss($periode->id);
            $orderData = $this->hasilRekapanCommandService->updateOrder($periode->id);
            DB::commit();

            $rekomendasiByPeriode = $this->hasilRekapanQueryService->getRekomendasiByPeriode($periode->id);

            return view('admin.pages.rekapan.hasil', compact('periode', 'orderData', 'dssData', 'rekomendasiByPeriode'));
        } catch (Throwable $th) {
            DB::rollBack();

            return to_route('admin.rekapan-spk.index')->with('error', $th->getMessage());
        }
    }

    public function datatableRekomendasi(Request $request)
    {
        return $this->hasilRekapanDatatableService->datatableRekomendasi($request);
    }

    public function datatableTerpilih(Request $request)
    {
        return $this->hasilRekapanDatatableService->datatableTerpilih($request);
    }

    public static function _getStatusPenilaian($tgl_awal, $tgl_akhir)
    {
        $element = '';
        if (Carbon::now()->format('Y-m-d H:i:s') < $tgl_awal) {
            $element .= '<div class="badge badge-pill badge-info"> Belum Dimulai </div>';
        } elseif (Carbon::now()->format('Y-m-d H:i:s') > $tgl_akhir) {
            $element .= '<div class="badge badge-pill badge-danger"> Sudah Berakhir </div>';
        } else {
            $element .= '<div class="badge badge-pill badge-success"> Sedang Berlangsung </div>';
        }

        return $element;
    }

    public function storeTerpilih(StoreDebiturTerpilihRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $this->hasilRekapanCommandService->storeTerpilih($request, $id);
            DB::commit();

            return to_route('admin.rekapan-spk.detail', $id)->with('success', 'Data Berhasil Ditambahkan');
        } catch (Throwable $th) {
            DB::rollBack();

            return to_route('admin.rekapan-spk.detail', $id)->with('error', $th->getMessage());
        }
    }

    public function deleteTerpilih(string $id_periode, string $id_terpilih)
    {
        try {
            DB::beginTransaction();
            $this->hasilRekapanCommandService->deleteTerpilih($id_periode, $id_terpilih);
            DB::commit();

            return to_route('admin.rekapan-spk.detail', $id_periode)->with('success', 'Data Berhasil Dihapus');
        } catch (Throwable $th) {
            DB::rollBack();

            return to_route('admin.rekapan-spk.detail', $id_periode)->with('error', $th->getMessage());
        }
    }

    public function publishTerpilih(string $id_periode)
    {
        try {
            DB::beginTransaction();
            $this->hasilRekapanCommandService->publishTerpilih($id_periode);
            DB::commit();

            return to_route('admin.rekapan-spk.detail', $id_periode)->with('success', 'Data Berhasil Dipublish');
        } catch (Throwable $th) {
            DB::rollBack();

            return to_route('admin.rekapan-spk.detail', $id_periode)->with('error', $th->getMessage());
        }
    }
}
