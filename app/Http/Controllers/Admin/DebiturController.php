<?php

namespace App\Http\Controllers\Admin;

use App\Exports\FormatImportDataExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\DebiturImportRequest;
use App\Http\Requests\DebiturStoreRequest;
use App\Http\Requests\DebiturUpdateRequest;
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
        return Excel::download(new FormatImportDataExport, 'template-import-debitur.xlsx');
    }

    public function import(DebiturImportRequest $request)
    {
        try {
            DB::beginTransaction();
            $response = Excel::import(new DebiturImport(), $request->file('file_excel'));
            DB::commit();
            return to_route('admin.master-data.debitur.index')->with('success', 'Data Berhasil Di Import');
        } catch (Throwable $th) {
            return to_route('admin.master-data.debitur.index')->with('error', 'Data Gagal Di Import');
        }
    }
    public function store(DebiturStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $store = $this->debiturCommandServices->store($request);
            DB::commit();

            return to_route('admin.master-data.debitur.index')->with('success', 'Data Berhasil Ditambahkan');
        } catch (Throwable $th) {
            DB::rollBack();

            return to_route('admin.master-data.debitur.index')->with('error', 'Data Gagal Ditambahkan');
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
            $store = $this->debiturCommandServices->update($request, $id);
            DB::commit();

            return to_route('admin.master-data.debitur.index')->with('success', 'Data Berhasil Diubah');
        } catch (Throwable $th) {
            DB::rollBack();
            dd($th);

            return to_route('admin.master-data.debitur.index')->with('error', 'Data Gagal Diubah');
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
            $detail->link_foto = asset('storage/images/foto-debitur/' . $detail->foto);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mendapatkan data debitur',
                'data' => $detail,
            ]);
        } catch (Throwable $th) {
            dd($th);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mendapatkan data debitur',
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
                'message' => 'Berhasil mengubah status debitur',
                'data' => $status,
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status debitur',
            ]);
        }
    }

    public function delete(string $id)
    {
        try {
            DB::beginTransaction();
            $delete = $this->debiturCommandServices->delete($id);
            DB::commit();

            return to_route('admin.master-data.debitur.index')->with('success', 'Data Berhasil Dihapus');
        } catch (Throwable $th) {
            DB::rollBack();

            return to_route('admin.master-data.debitur.index')->with('error', 'Data Gagal Dihapus');
        }
    }
}
