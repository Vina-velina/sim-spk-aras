<?php

namespace App\Http\Controllers\Admin;

use App\Exports\FormatImportPenilaianExport;
use App\Helpers\FormatDateToIndonesia;
use App\Http\Controllers\Controller;
use App\Http\Requests\Penilaian\PenilaianImportRequest;
use App\Http\Requests\Penilaian\PenilaianStoreUpdateRequest;
use App\Imports\PenilaianDebiturImport;
use App\Services\Debitur\DebiturDatatableServices;
use App\Services\Debitur\DebiturQueryServices;
use App\Services\Kriteria\KriteriaQueryServices;
use App\Services\Penilaian\PenilaianCommandService;
use App\Services\Periode\PeriodeQueryServices;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class PenilaianController extends Controller
{
    protected $debiturDatatableService;

    protected $periodeQueryService;

    protected $debiturQueryService;

    protected $kriteriaQueryService;

    protected $penilaianCommandService;

    public function __construct(
        DebiturDatatableServices $debiturDatatableService,
        PeriodeQueryServices $periodeQueryService,
        DebiturQueryServices $debiturQueryService,
        KriteriaQueryServices $kriteriaQueryService,
        PenilaianCommandService $penilaianCommandService
    ) {
        $this->debiturDatatableService = $debiturDatatableService;
        $this->periodeQueryService = $periodeQueryService;
        $this->debiturQueryService = $debiturQueryService;
        $this->kriteriaQueryService = $kriteriaQueryService;
        $this->penilaianCommandService = $penilaianCommandService;
    }

    public function index()
    {
        return view('admin.pages.penilaian.index');
    }

    public function detail(string $id)
    {
        $periode = $this->periodeQueryService->getOneWhereAktif($id);
        $periode->status_penilaian = self::_getStatusPenilaian($periode->tgl_awal_penilaian, $periode->tgl_akhir_penilaian);
        $periode->tgl_penilaian = FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_awal_penilaian).' s/d '.FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_akhir_penilaian);

        return view('admin.pages.penilaian.detail', compact('periode'));
    }

    public function createOrEditPenilaian(string $id_periode, string $id_debitur)
    {
        $periode = $this->periodeQueryService->getOneWhereAktif($id_periode);
        if (Carbon::now()->format('Y-m-d H:i:s') < $periode->tgl_awal_penilaian || Carbon::now()->format('Y-m-d H:i:s') > $periode->tgl_akhir_penilaian) {
            return redirect()->back()->with('error', 'Periode Penilaian Debitur Telah Usai/Belum Dimulai');
        }

        $periode->tgl_penilaian = FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_awal_penilaian).' s/d '.FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_akhir_penilaian);
        $debitur = $this->debiturQueryService->getOneWhereAktif($id_debitur);
        $kriteria = $this->kriteriaQueryService->getByIdPeriodeWhereAktif($id_periode);
        $kriteria->map(function ($item) use ($periode, $debitur) {
            $item->relasi_penilaian = $item->penilaian
                ->where('id_periode', $periode->id)
                ->where('id_debitur', $debitur->id)
                ->first();

            return $item;
        });

        return view('admin.pages.penilaian.createOrEdit', compact('periode', 'debitur', 'kriteria'));
    }

    public function storeOrUpdatePenilaian(PenilaianStoreUpdateRequest $request, string $id_periode, string $id_debitur)
    {
        try {
            DB::beginTransaction();
            $this->penilaianCommandService->storeOrUpdate($request, $id_periode, $id_debitur);
            DB::commit();

            return to_route('admin.penilaian.detail-penilaian', [$id_periode, $id_debitur])->with('success', 'Data Berhasil Ditambahkan');
        } catch (Throwable $th) {
            DB::rollBack();

            return to_route('admin.penilaian.detail-penilaian', [$id_periode, $id_debitur])->with('error', $th->getMessage());
        }
    }

    public function downloadTemplate(string $id_periode)
    {
        return Excel::download(new FormatImportPenilaianExport($id_periode), 'template-import-penilaian.xlsx');
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

    public function importData(PenilaianImportRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            Excel::import(new PenilaianDebiturImport($id), $request->file('file_excel'));
            DB::commit();

            return to_route('admin.penilaian.detail-penilaian', $id)->with('success', 'Data Berhasil Di Import');
        } catch (Throwable $th) {
            DB::rollBack();

            return to_route('admin.penilaian.detail-penilaian', $id)->with('error', $th->getMessage());
        }
    }
}
