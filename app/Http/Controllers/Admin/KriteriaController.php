<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FormatDateToIndonesia;
use App\Http\Controllers\Controller;
use App\Http\Requests\Kriteria\KriteriaStoreRequest;
use App\Http\Requests\Kriteria\KriteriaUpdateRequest;
use App\Http\Requests\Kriteria\SubKriteriaStoreRequest;
use App\Http\Requests\Kriteria\SubKriteriaUpdateRequest;
use App\Models\MasterKriteriaPenilaian;
use App\Services\Kriteria\KriteriaCommandServices;
use App\Services\Kriteria\KriteriaDatatableServices;
use App\Services\Kriteria\KriteriaQueryServices;
use App\Services\Periode\PeriodeDatatableServices;
use App\Services\Periode\PeriodeQueryServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class KriteriaController extends Controller
{
    protected $kriteriaCommandServices;

    protected $kriteriaDatatableServices;

    protected $periodeDatatableServices;

    protected $kriteriaQueryServices;

    protected $periodeQueryServices;

    public function __construct(
        KriteriaQueryServices $kriteriaQueryServices,
        KriteriaDatatableServices $kriteriaDatatableServices,
        PeriodeDatatableServices $periodeDatatableServices,
        KriteriaCommandServices $kriteriaCommandServices,
        PeriodeQueryServices $periodeQueryServices
    ) {
        $this->kriteriaCommandServices = $kriteriaCommandServices;
        $this->kriteriaDatatableServices = $kriteriaDatatableServices;
        $this->periodeDatatableServices = $periodeDatatableServices;
        $this->kriteriaQueryServices = $kriteriaQueryServices;
        $this->periodeQueryServices = $periodeQueryServices;
    }

    public function index()
    {
        return view('admin.pages.master-data.kriteria.index');
    }

    public function kriteria(string $id_periode)
    {
        $periode = $this->periodeQueryServices->getOneWhereAktif($id_periode);
        $periode->tgl_penilaian = FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_awal_penilaian).' s/d '.FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_akhir_penilaian);
        $periode->status_penilaian = self::_getStatusPenilaian($periode->tgl_awal_penilaian, $periode->tgl_akhir_penilaian);

        $kriteria = $this->kriteriaQueryServices->getByIdPeriodeWhereAktif($id_periode);
        $total_bobot = 0;
        foreach ($kriteria as $key => $value) {
            $total_bobot += $value->bobot_kriteria;
        }

        return view('admin.pages.master-data.kriteria.kriteria', compact('total_bobot', 'periode'));
    }

    public function create(string $id_periode)
    {
        $kriteria = $this->kriteriaQueryServices->getByIdPeriodeWhereAktif($id_periode);
        $periode = $this->periodeQueryServices->getOneWhereAktif($id_periode);
        $periode->status_penilaian = self::_getStatusPenilaian($periode->tgl_awal_penilaian, $periode->tgl_akhir_penilaian);
        $periode->tgl_penilaian = FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_awal_penilaian).' s/d '.FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_akhir_penilaian);

        // find total bobot
        $total_bobot = 0;
        foreach ($kriteria as $key => $value) {
            $total_bobot += $value->bobot_kriteria;
        }

        // ambil data master kriteria yang belum di pilih di periode ini
        $master_kriteria = MasterKriteriaPenilaian::whereNotIn('id', function ($query) use ($id_periode) {
            $query->select('id_master_kriteria')->from('kriteria_penilaians')->where('id_periode', $id_periode);
        })->get();

        return view('admin.pages.master-data.kriteria.create', compact('total_bobot', 'periode', 'master_kriteria'));
    }

    public function store(KriteriaStoreRequest $request, string $id)
    {
        try {
            $allKriteria = $this->kriteriaQueryServices->getByIdPeriodeWhereAktif($id);

            // find total bobot
            $total_bobot = 0;
            foreach ($allKriteria as $key => $value) {
                $total_bobot += $value->bobot_kriteria;
            }

            if ($total_bobot + $request->bobot_kriteria > 100) {
                return to_route('admin.master-data.kriteria.kriteria', $id)->with('error', 'Total Bobot Kriteria Melebihi 100%');
            }

            DB::beginTransaction();
            $kriteria = $this->kriteriaCommandServices->store($request);
            DB::commit();

            return to_route('admin.master-data.kriteria.edit', [$id, $kriteria->id])->with('success', 'Data Berhasil Ditambahkan');
        } catch (Throwable $th) {
            DB::rollBack();

            return to_route('admin.master-data.kriteria.kriteria', $id)->with('error', $th->getMessage());
        }
    }

    public function edit(string $id_periode, string $id_kriteria)
    {
        $allKriteria = $this->kriteriaQueryServices->getByIdPeriodeWhereAktif($id_periode);

        $periode = $this->periodeQueryServices->getOneWhereAktif($id_periode);
        $periode->tgl_penilaian = FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_awal_penilaian).' s/d '.FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_akhir_penilaian);
        $periode->status_penilaian = self::_getStatusPenilaian($periode->tgl_awal_penilaian, $periode->tgl_akhir_penilaian);

        // find total bobot
        $total_bobot = 0;
        foreach ($allKriteria as $key => $value) {
            $total_bobot += $value->bobot_kriteria;
        }

        $kriteria = $this->kriteriaQueryServices->getOne($id_kriteria);

        return view('admin.pages.master-data.kriteria.edit', compact('kriteria', 'total_bobot', 'periode'));
    }

    public function update(KriteriaUpdateRequest $request, string $id_periode, string $id_kriteria)
    {
        try {
            $allKriteria = $this->kriteriaQueryServices->getByIdPeriodeWhereAktif($id_periode);
            $kriteriaPenilaian = $this->kriteriaQueryServices->getOne($id_kriteria);

            // find total bobot
            $total_bobot = 0;
            foreach ($allKriteria as $key => $value) {
                if ($value->id != $kriteriaPenilaian->id) {
                    $total_bobot += $value->bobot_kriteria;
                }
            }

            if ($request->status == 'aktif') {
                if ($total_bobot + $request->bobot_kriteria > 100) {
                    throw new \Exception('Total Bobot Kriteria Melebihi 100%');
                }
            }

            DB::beginTransaction();
            $this->kriteriaCommandServices->update($request, $id_kriteria);
            DB::commit();

            return to_route('admin.master-data.kriteria.kriteria', $id_periode)->with('success', 'Data Berhasil Diperbaharui');
        } catch (Throwable $th) {
            DB::rollBack();

            return to_route('admin.master-data.kriteria.kriteria', $id_periode)->with('error', $th->getMessage());
        }
    }

    public function updateStatus(string $id_periode, string $id)
    {
        try {
            $allKriteria = $this->kriteriaQueryServices->getByIdPeriodeWhereAktif($id_periode);
            $kriteriaPenilaian = $this->kriteriaQueryServices->getOne($id);

            // find total bobot
            $total_bobot = 0;
            foreach ($allKriteria as $key => $value) {
                $total_bobot += $value->bobot_kriteria;
            }

            if ($kriteriaPenilaian->status == 'nonaktif') {
                if ($total_bobot + $kriteriaPenilaian->bobot_kriteria > 100) {
                    throw new \Exception('Total bobot lebih dari 100%, harap ubah bobot terlebih dahulu sebelum mengaktifkan kriteria ini');
                }
            }

            DB::beginTransaction();
            $status = $this->kriteriaCommandServices->updateStatus($id);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengubah status Kriteria',
                'data' => $status,
            ]);
        } catch (Throwable $th) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function delete(string $id_periode, string $id_kriteria)
    {
        try {
            DB::beginTransaction();
            $this->kriteriaCommandServices->destroy($id_kriteria);
            DB::commit();

            return to_route('admin.master-data.kriteria.kriteria', $id_periode)->with('success', 'Data Berhasil Dihapus');
        } catch (Throwable $th) {
            DB::rollBack();

            return to_route('admin.master-data.kriteria.kriteria', $id_periode)->with('error', $th->getMessage());
        }
    }

    public function datatable(Request $request)
    {
        return $this->kriteriaDatatableServices->datatable($request);
    }

    public function subCreate(string $id_periode, string $id_kriteria)
    {
        $periode = $this->periodeQueryServices->getOneWhereAktif($id_periode);
        $periode->tgl_penilaian = FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_awal_penilaian).' s/d '.FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_akhir_penilaian);
        $periode->status_penilaian = self::_getStatusPenilaian($periode->tgl_awal_penilaian, $periode->tgl_akhir_penilaian);

        return view('admin.pages.master-data.kriteria.sub-kriteria.create', compact('id_kriteria', 'periode'));
    }

    public function subStore(SubKriteriaStoreRequest $request, string $id_periode, string $id_kriteria)
    {
        try {
            DB::beginTransaction();
            $this->kriteriaCommandServices->subStore($request, $id_kriteria);
            DB::commit();

            return to_route('admin.master-data.kriteria.edit', [$id_periode, $id_kriteria])->with('success', 'Data Berhasil Ditambahkan');
        } catch (Throwable $th) {
            DB::rollBack();

            return to_route('admin.master-data.kriteria.edit', [$id_periode, $id_kriteria])->with('error', $th->getMessage());
        }
    }

    public function subEdit(string $id_periode, string $id_kriteria, string $id_sub_kriteria)
    {
        $subKriteriaPenilaian = $this->kriteriaQueryServices->getSubKriteriaById($id_sub_kriteria);

        return view('admin.pages.master-data.kriteria.sub-kriteria.edit', compact('subKriteriaPenilaian', 'id_kriteria', 'id_periode'));
    }

    public function subUpdate(SubKriteriaUpdateRequest $request, string $id_periode, string $id_kriteria, string $id_sub_kriteria)
    {
        try {
            DB::beginTransaction();
            $this->kriteriaCommandServices->subUpdate($request, $id_sub_kriteria);
            DB::commit();

            return to_route('admin.master-data.kriteria.edit', [$id_periode, $id_kriteria])->with('success', 'Data Berhasil Diperbaharui');
        } catch (Throwable $th) {
            DB::rollBack();

            return to_route('admin.master-data.kriteria.edit', [$id_periode, $id_kriteria])->with('error', $th->getMessage());
        }
    }

    public function subDelete(string $id_periode, string $id_kriteria, string $id_sub_kriteria)
    {
        try {
            // dd($subKriteriaPenilaian);
            DB::beginTransaction();
            $this->kriteriaCommandServices->subDestroy($id_sub_kriteria);
            DB::commit();

            return to_route('admin.master-data.kriteria.edit', [$id_periode, $id_kriteria])->with('success', 'Data Berhasil Dihapus');
        } catch (Throwable $th) {
            DB::rollBack();

            return to_route('admin.master-data.kriteria.edit', [$id_periode, $id_kriteria])->with('error', $th->getMessage());
        }
    }

    public function sub_datatable(Request $request)
    {
        return $this->kriteriaDatatableServices->sub_datatable($request);
    }

    public function periodeDataTable(Request $request)
    {
        return $this->periodeDatatableServices->datatable($request);
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
}
