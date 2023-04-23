<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FormatDateToIndonesia;
use App\Http\Controllers\Controller;
use App\Http\Requests\Kriteria\KriteriaStoreRequest;
use App\Http\Requests\Kriteria\KriteriaUpdateRequest;
use App\Http\Requests\Kriteria\SubKriteriaStoreRequest;
use App\Http\Requests\Kriteria\SubKriteriaUpdateRequest;
use App\Models\KriteriaPenilaian;
use App\Models\MasterKriteriaPenilaian;
use App\Models\SubKriteriaPenilaian;
use App\Services\Kriteria\KriteriaCommandServices;
use App\Services\Kriteria\KriteriaDatatableServices;
use App\Services\Kriteria\KriteriaQueryServices;
use App\Services\Periode\PeriodeQueryServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class KriteriaController extends Controller
{

    protected $kriteriaCommandServices;

    protected $kriteriaDatatableServices;

    protected $kriteriaQueryServices;

    protected $periodeQueryServices;

    public function __construct(
        KriteriaQueryServices $kriteriaQueryServices,
        KriteriaDatatableServices $kriteriaDatatableServices,
        KriteriaCommandServices $kriteriaCommandServices,
        PeriodeQueryServices $periodeQueryServices
    ) {
        $this->kriteriaCommandServices = $kriteriaCommandServices;
        $this->kriteriaDatatableServices = $kriteriaDatatableServices;
        $this->kriteriaQueryServices = $kriteriaQueryServices;
        $this->periodeQueryServices = $periodeQueryServices;
    }

    public function index()
    {
        return view('admin.pages.master-data.kriteria.index');
    }

    public function kriteria(string $id)
    {

        $periode = $this->periodeQueryServices->getOne($id);
        if (isset($periode)) {
            $periode->tgl_penilaian =  FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_awal_penilaian) . ' s/d ' .  FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_akhir_penilaian);
        }
        $kriteria = $this->kriteriaQueryServices->getByIdPeriode($id);
        $total_bobot = 0;
        foreach ($kriteria as $key => $value) {
            $total_bobot += $value->bobot_kriteria;
        }

        return view('admin.pages.master-data.kriteria.kriteria', compact('total_bobot', 'periode'));
    }

    public function create(string $id)
    {
        $kriteria = $this->kriteriaQueryServices->getByIdPeriode($id);
        $periode = $this->periodeQueryServices->getOne($id);
        if (isset($periode)) {
            $periode->tgl_penilaian =  FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_awal_penilaian) . ' s/d ' .  FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_akhir_penilaian);
        }

        // find total bobot
        $total_bobot = 0;
        foreach ($kriteria as $key => $value) {
            $total_bobot += $value->bobot_kriteria;
        }

        // ambil data master kriteria yang belum di pilih di periode ini
        $master_kriteria = MasterKriteriaPenilaian::whereNotIn('id', function ($query) use ($id) {
            $query->select('id_master_kriteria')->from('kriteria_penilaians')->where('id_periode', $id);
        })->get();

        return view('admin.pages.master-data.kriteria.create', compact('total_bobot', 'periode', 'master_kriteria'));
    }

    public function store(KriteriaStoreRequest $request, string $id)
    {
        try {
            $allKriteria = $this->kriteriaQueryServices->getByIdPeriode($id);

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
            // dd($kriteria->id);
            return to_route('admin.master-data.kriteria.edit', [$id, $kriteria->id])->with('success', 'Data Berhasil Di Simpan');
        } catch (Throwable $th) {
            DB::rollBack();
            return to_route('admin.master-data.kriteria.kriteria', $id)->with('error', 'Data Gagal Di Simpan');
        }
    }

    public function edit(string $id_periode, string $id_kriteria)
    {

        $allKriteria = $this->kriteriaQueryServices->getByIdPeriode($id_periode);

        $periode = $this->periodeQueryServices->getOne($id_periode);
        if (isset($periode)) {
            $periode->tgl_penilaian =  FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_awal_penilaian) . ' s/d ' .  FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_akhir_penilaian);
        }

        // find total bobot
        $total_bobot = 0;
        foreach ($allKriteria as $key => $value) {
            $total_bobot += $value->bobot_kriteria;
        }

        $kriteria = $this->kriteriaQueryServices->getOne($id_kriteria);

        // ambil data master kriteria yang belum di pilih di periode ini tidak termasuk kriteria yang sedang diedit
        $master_kriteria = MasterKriteriaPenilaian::whereNotIn('id', function ($query) use ($id_periode, $kriteria) {
            $query->select('id_master_kriteria')->from('kriteria_penilaians')->where('id_periode', $id_periode)->where('id', '!=', $kriteria->id);
        })->get();

        // dd($kriteria->subKriteriaPenilaian);
        return view('admin.pages.master-data.kriteria.edit', compact('kriteria', 'total_bobot', 'periode', 'master_kriteria'));
    }

    public function update(KriteriaUpdateRequest $request, $id, KriteriaPenilaian $kriteriaPenilaian)
    {
        try {
            $allKriteria = $this->kriteriaQueryServices->getByIdPeriode($id);

            // find total bobot
            $total_bobot = 0;
            foreach ($allKriteria as $key => $value) {
                $total_bobot += $value->bobot_kriteria;
            }

            if ($total_bobot + $request->bobot_kriteria - $kriteriaPenilaian->bobot_kriteria > 100) {
                return to_route('admin.master-data.kriteria.kriteria', $id)->with('error', 'Total Bobot Kriteria Melebihi 100%');
            }

            DB::beginTransaction();
            $this->kriteriaCommandServices->update($request, $kriteriaPenilaian);
            DB::commit();
            return to_route('admin.master-data.kriteria.kriteria', $id)->with('success', 'Data Berhasil Di Update');
        } catch (Throwable $th) {
            DB::rollBack();
            return to_route('admin.master-data.kriteria.kriteria', $id)->with('error', 'Data Gagal Di Update');
        }
    }

    public function updateStatus(KriteriaPenilaian $kriteriaPenilaian)
    {
        try {
            DB::beginTransaction();
            $status = $this->kriteriaCommandServices->updateStatus($kriteriaPenilaian);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengubah status debitur',
                'data' => $status,
            ]);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status debitur',
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function delete($id, KriteriaPenilaian $kriteriaPenilaian)
    {
        try {
            DB::beginTransaction();
            $this->kriteriaCommandServices->destroy($kriteriaPenilaian);
            DB::commit();
            return to_route('admin.master-data.kriteria.kriteria', $id)->with('success', 'Data Berhasil Di Hapus');
        } catch (Throwable $th) {
            DB::rollBack();
            return to_route('admin.master-data.kriteria.kriteria', $id)->with('error', 'Data Gagal Di Hapus');
        }
    }

    public function datatable(Request $request)
    {
        return $this->kriteriaDatatableServices->datatable($request);
    }

    public function subCreate(string $id, KriteriaPenilaian $kriteriaPenilaian)
    {
        $periode = $this->periodeQueryServices->getOne($id);
        if (isset($periode)) {
            $periode->tgl_penilaian =  FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_awal_penilaian) . ' s/d ' .  FormatDateToIndonesia::getIndonesiaDateTime($periode->tgl_akhir_penilaian);
        }

        return view('admin.pages.master-data.kriteria.sub-kriteria.create', compact('kriteriaPenilaian', 'periode'));
    }

    public function subStore(SubKriteriaStoreRequest $request, $id, KriteriaPenilaian $kriteriaPenilaian)
    {
        try {
            DB::beginTransaction();
            $this->kriteriaCommandServices->subStore($kriteriaPenilaian, $request);
            DB::commit();
            return to_route('admin.master-data.kriteria.edit', [$id, $kriteriaPenilaian->id])->with('success', 'Data Berhasil Di Simpan');
        } catch (Throwable $th) {
            DB::rollBack();
            return to_route('admin.master-data.kriteria.edit', [$id, $kriteriaPenilaian->id])->with('error', 'Data Gagal Di Simpan');
        }
    }

    public function subEdit(KriteriaPenilaian $kriteriaPenilaian, $id)
    {
        $subKriteriaPenilaian = $this->kriteriaQueryServices->getSubKriteriaById($id);
        return view('admin.pages.master-data.kriteria.sub-kriteria.edit', compact('subKriteriaPenilaian',  'kriteriaPenilaian'));
    }

    public function subUpdate($id, SubKriteriaPenilaian $subKriteriaPenilaian, SubKriteriaUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->kriteriaCommandServices->subUpdate($subKriteriaPenilaian, $request);
            DB::commit();
            return to_route('admin.master-data.kriteria.edit', [$id, $subKriteriaPenilaian->kriteriaPenilaian->id])->with('success', 'Data Berhasil Di Update');
        } catch (Throwable $th) {
            DB::rollBack();
            return to_route('admin.master-data.kriteria.edit', [$id, $subKriteriaPenilaian->kriteriaPenilaian->id])->with('error', 'Data Gagal Di Update');
        }
    }

    public function subDelete($id, SubKriteriaPenilaian $subKriteriaPenilaian)
    {
        try {
            // dd($subKriteriaPenilaian);
            DB::beginTransaction();
            $this->kriteriaCommandServices->subDestroy($subKriteriaPenilaian);
            DB::commit();
            return to_route('admin.master-data.kriteria.edit', [$id, $subKriteriaPenilaian->kriteriaPenilaian->id])->with('success', 'Data Berhasil Di Hapus');
        } catch (Throwable $th) {
            DB::rollBack();
            return to_route('admin.master-data.kriteria.edit', [$id, $subKriteriaPenilaian->kriteriaPenilaian->id])->with('error', 'Data Gagal Di Hapus');
        }
    }

    public function sub_datatable(Request $request)
    {
        return $this->kriteriaDatatableServices->sub_datatable($request);
    }

    public function periodeDataTable(Request $request)
    {
        return $this->kriteriaDatatableServices->periodeDataTable($request);
    }
}
