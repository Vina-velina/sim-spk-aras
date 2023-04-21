<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kategori\KategoriStoreRequest;
use App\Http\Requests\Kategori\KategoriUpdateRequest;
use App\Http\Requests\Kategori\SubKategoriStoreRequest;
use App\Http\Requests\Kategori\SubKategoriUpdateRequest;
use App\Models\KriteriaPenilaian;
use App\Models\SubKriteriaPenilaian;
use App\Services\Kategori\KategoriCommandServices;
use App\Services\Kategori\KategoriDatatableServices;
use App\Services\Kategori\KategoriQueryServices;
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
        return view('admin.pages.master-data.kriteria.index');
    }

    public function create()
    {
        return view('admin.pages.master-data.kriteria.create');
    }

    public function store(KategoriStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $kriteria = $this->kategoriCommandServices->store($request);
            DB::commit();
            return to_route('admin.master-data.kategori.edit', $kriteria->id)->with('success', 'Data Berhasil Di Simpan');
        } catch (Throwable $th) {
            DB::rollBack();
            return to_route('admin.master-data.kategori.index')->with('error', 'Data Gagal Di Simpan');
        }
    }

    public function edit($id)
    {
        $kriteria = $this->kategoriQueryServices->getOne($id)->with('subKriteriaPenilaian')->first();
        // dd($kriteria->subKriteriaPenilaian);
        return view('admin.pages.master-data.kriteria.edit', compact('kriteria'));
    }

    public function update(KategoriUpdateRequest $request, KriteriaPenilaian $kriteriaPenilaian)
    {
        try {
            DB::beginTransaction();
            $this->kategoriCommandServices->update($request, $kriteriaPenilaian);
            DB::commit();
            return to_route('admin.master-data.kategori.index')->with('success', 'Data Berhasil Di Update');
        } catch (Throwable $th) {
            DB::rollBack();
            return to_route('admin.master-data.kategori.index')->with('error', 'Data Gagal Di Update');
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

    public function delete(KriteriaPenilaian $kriteriaPenilaian)
    {
        try {
            DB::beginTransaction();
            $this->kategoriCommandServices->destroy($kriteriaPenilaian);
            DB::commit();
            return to_route('admin.master-data.kategori.index')->with('success', 'Data Berhasil Di Hapus');
        } catch (Throwable $th) {
            DB::rollBack();
            return to_route('admin.master-data.kategori.index')->with('error', 'Data Gagal Di Hapus');
        }
    }

    public function datatable()
    {
        return $this->kategoriDatatableServices->datatable();
    }

    public function subCreate(KriteriaPenilaian $kriteriaPenilaian)
    {
        return view('admin.pages.master-data.kriteria.sub-kriteria.create', compact('kriteriaPenilaian'));
    }

    public function subStore(SubKategoriStoreRequest $request, KriteriaPenilaian $kriteriaPenilaian)
    {
        try {
            // dd($kriteriaPenilaian->id);
            DB::beginTransaction();
            $this->kategoriCommandServices->subStore($kriteriaPenilaian, $request);
            DB::commit();
            return to_route('admin.master-data.kategori.edit', $kriteriaPenilaian->id)->with('success', 'Data Berhasil Di Simpan');
        } catch (Throwable $th) {
            dd($th->getMessage());
            DB::rollBack();
            return to_route('admin.master-data.kategori.edit', $kriteriaPenilaian->id)->with('error', 'Data Gagal Di Simpan');
        }
    }

    public function subEdit(SubKriteriaPenilaian $subKriteriaPenilaian)
    {
        // dd($subKriteriaPenilaian);
        return view('admin.pages.master-data.kriteria.sub-kriteria.edit', compact('subKriteriaPenilaian'));
    }

    public function subUpdate(SubKriteriaPenilaian $subKriteriaPenilaian, SubKategoriUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->kategoriCommandServices->subUpdate($subKriteriaPenilaian, $request);
            DB::commit();
            return to_route('admin.master-data.kategori.edit', $subKriteriaPenilaian->kriteriaPenilaian->id)->with('success', 'Data Berhasil Di Update');
        } catch (Throwable $th) {
            DB::rollBack();
            return to_route('admin.master-data.kategori.edit', $subKriteriaPenilaian->kriteriaPenilaian->id)->with('error', 'Data Gagal Di Update');
        }
    }

    public function subDelete(SubKriteriaPenilaian $subKriteriaPenilaian)
    {
        try {
            // dd($subKriteriaPenilaian);
            DB::beginTransaction();
            $this->kategoriCommandServices->subDestroy($subKriteriaPenilaian);
            DB::commit();
            return to_route('admin.master-data.kategori.edit', $subKriteriaPenilaian->kriteriaPenilaian->id)->with('success', 'Data Berhasil Di Hapus');
        } catch (Throwable $th) {
            DB::rollBack();
            return to_route('admin.master-data.kategori.edit', $subKriteriaPenilaian->kriteriaPenilaian->id)->with('error', 'Data Gagal Di Hapus');
        }
    }

    public function sub_datatable(KriteriaPenilaian $kriteriaPenilaian)
    {
        return $this->kategoriDatatableServices->sub_datatable($kriteriaPenilaian);
    }
}