<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FormatDateToIndonesia;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterKriteria\MasterKriteriaStoreRequest;
use App\Http\Requests\MasterKriteria\MasterKriteriaUpdateRequest;
use App\Models\MasterKriteriaPenilaian;
use App\Services\MasterKriteria\MasterKriteriaCommandServices;
use App\Services\MasterKriteria\MasterKriteriaDatatableServices;
use App\Services\MasterKriteria\MasterKriteriaQueryServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterKriteriaController extends Controller
{

    protected $masterKriteriaCommandServices;
    protected $masterKriteriaDatatableServices;
    protected $masterKriteriaQueryServices;

    public function __construct(
        MasterKriteriaQueryServices $masterKriteriaQueryServices,
        MasterKriteriaDatatableServices $masterKriteriaDatatableServices,
        MasterKriteriaCommandServices $masterKriteriaCommandServices
    ) {
        $this->masterKriteriaCommandServices = $masterKriteriaCommandServices;
        $this->masterKriteriaDatatableServices = $masterKriteriaDatatableServices;
        $this->masterKriteriaQueryServices = $masterKriteriaQueryServices;
    }

    public function index()
    {
        return view('admin.pages.master-data.master-kriteria.index');
    }

    public function create()
    {
        return view('admin.pages.master-data.master-kriteria.create');
    }

    public function store(MasterKriteriaStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->masterKriteriaCommandServices->store($request);
            DB::commit();
            return redirect()->route('admin.master-data.master-kriteria.index')->with('success', 'Data berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            return redirect()->back()->with('error', 'Data gagal ditambahkan');
        }
    }

    public function edit(MasterKriteriaPenilaian $masterKriteriaPenilaian)
    {
        // $data = $this->masterKriteriaQueryServices->getOne($id);
        $kriteria = $masterKriteriaPenilaian;
        return view('admin.pages.master-data.master-kriteria.edit', compact('kriteria'));
    }

    public function update(MasterKriteriaUpdateRequest $request, MasterKriteriaPenilaian $masterKriteriaPenilaian)
    {
        try {
            DB::beginTransaction();
            $this->masterKriteriaCommandServices->update($request, $masterKriteriaPenilaian);
            DB::commit();
            return redirect()->route('admin.master-data.master-kriteria.index')->with('success', 'Data berhasil diubah');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            return redirect()->back()->with('error', 'Data gagal diubah');
        }
    }

    public function delete(MasterKriteriaPenilaian $masterKriteriaPenilaian)
    {
        try {
            DB::beginTransaction();
            $this->masterKriteriaCommandServices->destroy($masterKriteriaPenilaian);
            DB::commit();
            return redirect()->route('admin.master-data.master-kriteria.index')->with('success', 'Data berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Data gagal dihapus');
        }
    }

    public function detail(MasterKriteriaPenilaian $masterKriteriaPenilaian)
    {
        try {
            // $data = $this->masterKriteriaQueryServices->getOne($masterKriteriaPenilaian->id);
            $data = $masterKriteriaPenilaian;

            $created_at = FormatDateToIndonesia::getIndonesiaDateTime($data->created_at);
            $updated_at = FormatDateToIndonesia::getIndonesiaDateTime($data->updated_at);

            return response()->json([
                'success' => true,
                'status' => 'success',
                'data' => $data,
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'data' => $th->getMessage()
            ]);
        }
    }

    public function datatable(Request $request)
    {
        return $this->masterKriteriaDatatableServices->datatable($request);
    }
}
