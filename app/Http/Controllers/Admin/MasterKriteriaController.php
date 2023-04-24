<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FormatDateToIndonesia;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterKriteria\MasterKriteriaStoreRequest;
use App\Http\Requests\MasterKriteria\MasterKriteriaUpdateRequest;
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

            return to_route('admin.master-data.master-kriteria.index')->with('success', 'Data berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit(string $id)
    {
        $kriteria = $this->masterKriteriaQueryServices->getOne($id);

        return view('admin.pages.master-data.master-kriteria.edit', compact('kriteria'));
    }

    public function update(MasterKriteriaUpdateRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $this->masterKriteriaCommandServices->update($request, $id);
            DB::commit();

            return to_route('admin.master-data.master-kriteria.index')->with('success', 'Data berhasil diperbaharui');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function delete(string $id)
    {
        try {
            DB::beginTransaction();
            $this->masterKriteriaCommandServices->destroy($id);
            DB::commit();

            return to_route('admin.master-data.master-kriteria.index')->with('success', 'Data berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function detail(string $id)
    {
        try {
            $data = $this->masterKriteriaQueryServices->getOne($id);

            $created_at = FormatDateToIndonesia::getIndonesiaDateTime($data->created_at);
            $updated_at = FormatDateToIndonesia::getIndonesiaDateTime($data->updated_at);

            return response()->json([
                'success' => true,
                'status' => 'success',
                'data' => $data,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function datatable(Request $request)
    {
        return $this->masterKriteriaDatatableServices->datatable($request);
    }
}
