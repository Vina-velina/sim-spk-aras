<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DebiturExport;
use App\Exports\FormatImportDebiturExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Debitur\DebiturImportRequest;
use App\Http\Requests\Debitur\DebiturStoreRequest;
use App\Http\Requests\Debitur\DebiturUpdateRequest;
use App\Imports\DebiturImport;
use App\Services\Debitur\DebiturCommandServices;
use App\Services\Debitur\DebiturDatatableServices;
use App\Services\Debitur\DebiturQueryServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class DebiturController extends Controller
{
    protected $debiturCommandServices;

    protected $debiturDatatableServices;

    protected $debiturQueryServices;

    public function __construct(
        DebiturQueryServices $debiturQueryServices,
        DebiturDatatableServices $debiturDatatableServices,
        DebiturCommandServices $debiturCommandServices
    ) {
        $this->debiturCommandServices = $debiturCommandServices;
        $this->debiturDatatableServices = $debiturDatatableServices;
        $this->debiturQueryServices = $debiturQueryServices;
    }

    public function index()
    {
        return view('admin.pages.master-data.debitur.index');
    }

    public function downloadTemplate()
    {
        return Excel::download(new FormatImportDebiturExport, 'template-import-debitur.xlsx');
    }

    public function import(DebiturImportRequest $request)
    {
        try {
            DB::beginTransaction();
            Excel::import(new DebiturImport(), $request->file('file_excel'));
            DB::commit();

            return to_route('admin.master-data.debitur.index')->with('success', 'Data Berhasil Di Import');
        } catch (Throwable $th) {
            DB::rollBack();

            return to_route('admin.master-data.debitur.index')->with('error', $th->getMessage());
        }
    }

    public function export(Request $request)
    {
        return Excel::download(new DebiturExport($request->status_aktif), 'export-data-debitur.xlsx');
    }

    public function store(DebiturStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->debiturCommandServices->store($request);
            DB::commit();

            return to_route('admin.master-data.debitur.index')->with('success', 'Data Berhasil Ditambahkan');
        } catch (Throwable $th) {
            DB::rollBack();

            return to_route('admin.master-data.debitur.index')->with('error', $th->getMessage());
        }
    }

    public function datatable(Request $request)
    {
        return $this->debiturDatatableServices->datatable($request);
    }

    public function update(DebiturUpdateRequest $request, string $id)
    {
        $request->request->add(['id' => $id]);
        try {
            DB::beginTransaction();
            $this->debiturCommandServices->update($request, $id);
            DB::commit();

            return to_route('admin.master-data.debitur.index')->with('success', 'Data Berhasil Diperbaharui');
        } catch (Throwable $th) {
            DB::rollBack();

            return to_route('admin.master-data.debitur.index')->with('error', $th->getMessage());
        }
    }

    public function edit(string $id)
    {
        $detail = $this->debiturQueryServices->getOne($id);

        return view('admin.pages.master-data.debitur.edit', compact('detail'));
    }

    public function create()
    {
        return view('admin.pages.master-data.debitur.create');
    }

    public function detail(string $id)
    {
        try {
            $detail = $this->debiturQueryServices->getOne($id);
            $path = 'storage/foto-debitur/';
            $detail->link_foto = asset($path.$detail->foto);

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Didapatkan',
                'data' => $detail,
            ]);
        } catch (Throwable $th) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function updateStatus(string $id)
    {
        try {
            DB::beginTransaction();
            $status = $this->debiturCommandServices->updateStatus($id);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Diperbaharui',
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

    public function delete(string $id)
    {
        try {
            DB::beginTransaction();
            $this->debiturCommandServices->delete($id);
            DB::commit();

            return to_route('admin.master-data.debitur.index')->with('success', 'Data Berhasil Dihapus');
        } catch (Throwable $th) {
            DB::rollBack();

            return to_route('admin.master-data.debitur.index')->with('error', $th->getMessage());
        }
    }
}
