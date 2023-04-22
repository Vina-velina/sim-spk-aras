<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kategori\KategoriStoreRequest;
use App\Http\Requests\Kategori\KategoriUpdateRequest;
use App\Http\Requests\Kategori\SubKategoriStoreRequest;
use App\Http\Requests\Kategori\SubKategoriUpdateRequest;
use App\Models\KriteriaPenilaian;
use App\Models\MasterKriteriaPenilaian;
use App\Models\SubKriteriaPenilaian;
use App\Services\Kategori\KategoriCommandServices;
use App\Services\Kategori\KategoriDatatableServices;
use App\Services\Kategori\KategoriQueryServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class KategoriController extends Controller
{

    protected $kategoriCommandServices;

    protected $kategoriDatatableServices;

    protected $kategoriQueryServices;

    public function __construct(
        KategoriQueryServices $kategoriQueryServices,
        KategoriDatatableServices $kategoriDatatableServices,
        KategoriCommandServices $kategoriCommandServices
    ) {
        $this->kategoriCommandServices = $kategoriCommandServices;
        $this->kategoriDatatableServices = $kategoriDatatableServices;
        $this->kategoriQueryServices = $kategoriQueryServices;
    }

    public function index()
    {
        // $kriteria = $this->kategoriQueryServices->getByIdPeriode($id);

        // // find total bobot
        // $total_bobot = 0;
        // foreach ($kriteria as $key => $value) {
        //     $total_bobot += $value->bobot_kriteria;
        // }

        return view('admin.pages.master-data.kriteria.index');
    }

    public function kriteria($id)
    {
        $kriteria = $this->kategoriQueryServices->getByIdPeriode($id);

        // find total bobot
        $total_bobot = 0;
        foreach ($kriteria as $key => $value) {
            $total_bobot += $value->bobot_kriteria;
        }

        return view('admin.pages.master-data.kriteria.kriteria', compact('total_bobot', 'id'));
    }

    public function create($id)
    {
        $kriteria = $this->kategoriQueryServices->getByIdPeriode($id);

        // find total bobot
        $total_bobot = 0;
        foreach ($kriteria as $key => $value) {
            $total_bobot += $value->bobot_kriteria;
        }

        // ambil data master kriteria yang belum di pilih di periode ini
        $master_kriteria = MasterKriteriaPenilaian::whereNotIn('id', function ($query) use ($id) {
            $query->select('id_master_kriteria')->from('kriteria_penilaians')->where('id_periode', $id);
        })->get();

        return view('admin.pages.master-data.kriteria.create', compact('total_bobot', 'id', 'master_kriteria'));
    }

    public function store(KategoriStoreRequest $request, $id)
    {
        // dd($request->all());
        try {
            $allKriteria = $this->kategoriQueryServices->getByIdPeriode($id);

            // find total bobot
            $total_bobot = 0;
            foreach ($allKriteria as $key => $value) {
                $total_bobot += $value->bobot_kriteria;
            }

            if ($total_bobot + $request->bobot_kriteria > 100) {
                return to_route('admin.master-data.kategori.kriteria', $id)->with('error', 'Total Bobot Kriteria Melebihi 100%');
            }

            DB::beginTransaction();
            $kriteria = $this->kategoriCommandServices->store($request);
            DB::commit();
            // dd($kriteria->id);
            return to_route('admin.master-data.kategori.edit', [$id, $kriteria->id])->with('success', 'Data Berhasil Di Simpan');
        } catch (Throwable $th) {
            dd($th->getMessage());
            DB::rollBack();
            return to_route('admin.master-data.kategori.kriteria', $id)->with('error', 'Data Gagal Di Simpan');
        }
    }

    public function edit($id, KriteriaPenilaian $kriteriaPenilaian)
    {
        $allKriteria = $this->kategoriQueryServices->getByIdPeriode($id);

        // find total bobot
        $total_bobot = 0;
        foreach ($allKriteria as $key => $value) {
            $total_bobot += $value->bobot_kriteria;
        }

        $kriteria = $kriteriaPenilaian;

        $bobot_kriteria = $kriteria->bobot_kriteria;

        // ambil data master kriteria yang belum di pilih di periode ini tidak termasuk kriteria yang sedang diedit
        $master_kriteria = MasterKriteriaPenilaian::whereNotIn('id', function ($query) use ($id, $kriteria) {
            $query->select('id_master_kriteria')->from('kriteria_penilaians')->where('id_periode', $id)->where('id', '!=', $kriteria->id);
        })->get();

        // dd($kriteria->subKriteriaPenilaian);
        return view('admin.pages.master-data.kriteria.edit', compact('kriteria', 'total_bobot', 'bobot_kriteria', 'id', 'master_kriteria'));
    }

    public function update(KategoriUpdateRequest $request, $id, KriteriaPenilaian $kriteriaPenilaian)
    {
        try {
            $allKriteria = $this->kategoriQueryServices->getByIdPeriode($id);

            // find total bobot
            $total_bobot = 0;
            foreach ($allKriteria as $key => $value) {
                $total_bobot += $value->bobot_kriteria;
            }

            if ($total_bobot + $request->bobot_kriteria - $kriteriaPenilaian->bobot_kriteria > 100) {
                return to_route('admin.master-data.kategori.kriteria', $id)->with('error', 'Total Bobot Kriteria Melebihi 100%');
            }

            DB::beginTransaction();
            $this->kategoriCommandServices->update($request, $kriteriaPenilaian);
            DB::commit();
            return to_route('admin.master-data.kategori.kriteria', $id)->with('success', 'Data Berhasil Di Update');
        } catch (Throwable $th) {
            dd($th->getMessage());
            DB::rollBack();
            return to_route('admin.master-data.kategori.kriteria', $id)->with('error', 'Data Gagal Di Update');
        }
    }

    public function updateStatus(KriteriaPenilaian $kriteriaPenilaian)
    {
        try {
            DB::beginTransaction();
            $status = $this->kategoriCommandServices->updateStatus($kriteriaPenilaian);
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
            $this->kategoriCommandServices->destroy($kriteriaPenilaian);
            DB::commit();
            return to_route('admin.master-data.kategori.kriteria', $id)->with('success', 'Data Berhasil Di Hapus');
        } catch (Throwable $th) {
            DB::rollBack();
            return to_route('admin.master-data.kategori.kriteria', $id)->with('error', 'Data Gagal Di Hapus');
        }
    }

    public function datatable(Request $request)
    {
        return $this->kategoriDatatableServices->datatable($request);
    }

    public function subCreate($id, KriteriaPenilaian $kriteriaPenilaian)
    {
        return view('admin.pages.master-data.kriteria.sub-kriteria.create', compact('kriteriaPenilaian', 'id'));
    }

    public function subStore(SubKategoriStoreRequest $request, $id, KriteriaPenilaian $kriteriaPenilaian)
    {
        try {
            // dd($kriteriaPenilaian->id);
            DB::beginTransaction();
            $this->kategoriCommandServices->subStore($kriteriaPenilaian, $request);
            DB::commit();
            return to_route('admin.master-data.kategori.edit', [$id, $kriteriaPenilaian->id])->with('success', 'Data Berhasil Di Simpan');
        } catch (Throwable $th) {
            dd($th->getMessage());
            DB::rollBack();
            return to_route('admin.master-data.kategori.edit', [$id, $kriteriaPenilaian->id])->with('error', 'Data Gagal Di Simpan');
        }
    }

    public function subEdit($id, SubKriteriaPenilaian $subKriteriaPenilaian)
    {
        // dd($subKriteriaPenilaian);
        return view('admin.pages.master-data.kriteria.sub-kriteria.edit', compact('subKriteriaPenilaian', 'id'));
    }

    public function subUpdate($id, SubKriteriaPenilaian $subKriteriaPenilaian, SubKategoriUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->kategoriCommandServices->subUpdate($subKriteriaPenilaian, $request);
            DB::commit();
            return to_route('admin.master-data.kategori.edit', [$id, $subKriteriaPenilaian->kriteriaPenilaian->id])->with('success', 'Data Berhasil Di Update');
        } catch (Throwable $th) {
            DB::rollBack();
            return to_route('admin.master-data.kategori.edit', [$id, $subKriteriaPenilaian->kriteriaPenilaian->id])->with('error', 'Data Gagal Di Update');
        }
    }

    public function subDelete($id, SubKriteriaPenilaian $subKriteriaPenilaian)
    {
        try {
            // dd($subKriteriaPenilaian);
            DB::beginTransaction();
            $this->kategoriCommandServices->subDestroy($subKriteriaPenilaian);
            DB::commit();
            return to_route('admin.master-data.kategori.edit', [$id, $subKriteriaPenilaian->kriteriaPenilaian->id])->with('success', 'Data Berhasil Di Hapus');
        } catch (Throwable $th) {
            DB::rollBack();
            return to_route('admin.master-data.kategori.edit', [$id, $subKriteriaPenilaian->kriteriaPenilaian->id])->with('error', 'Data Gagal Di Hapus');
        }
    }

    public function sub_datatable(Request $request)
    {
        return $this->kategoriDatatableServices->sub_datatable($request);
    }

    public function periodeDataTable(Request $request)
    {
        return $this->kategoriDatatableServices->periodeDataTable($request);
    }
}
