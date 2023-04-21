<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FormatDateToIndonesia;
use App\Http\Controllers\Controller;
use App\Http\Requests\Periode\PeriodeStoreRequest;
use App\Http\Requests\Periode\PeriodeUpdateRequest;
use App\Models\Periode;
use App\Services\Periode\PeriodeCommandServices;
use App\Services\Periode\PeriodeDatatableServices;
use App\Services\Periode\PeriodeQueryServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PeriodeController extends Controller
{
    protected $periodeCommandServices;

    protected $periodeDatatableServices;

    protected $periodeQueryServices;

    public function __construct(
        PeriodeQueryServices $periodeQueryServices,
        PeriodeDatatableServices $periodeDatatableServices,
        PeriodeCommandServices $periodeCommandServices
    ) {
        $this->periodeCommandServices = $periodeCommandServices;
        $this->periodeDatatableServices = $periodeDatatableServices;
        $this->periodeQueryServices = $periodeQueryServices;
    }

    // Halaman index periode
    public function index()
    {
        return view('admin.pages.master-data.periode.index');
    }

    public function detail(string $id)
    {
        try {
            $detail = $this->periodeQueryServices->getOne($id);
            // $detail->link_foto = asset('storage/images/foto-periode/' . $detail->foto);

            $detail->tgl_awal_penilaian = FormatDateToIndonesia::getIndonesiaDateTime($detail->tgl_awal_penilaian);
            $detail->tgl_akhir_penilaian = FormatDateToIndonesia::getIndonesiaDateTime($detail->tgl_akhir_penilaian);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mendapatkan data periode',
                'data' => $detail,
            ]);
        } catch (Throwable $th) {
            dd($th);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mendapatkan data periode',
            ]);
        }
    }

    // Penambahan data periode
    public function create()
    {
        return view('admin.pages.master-data.periode.create');
    }

    public function store(PeriodeStoreRequest $request)
    {
        $this->periodeCommandServices->store($request);

        return redirect()->route('admin.master-data.periode.index')->with('success', 'Data berhasil disimpan');
    }

    // Pengubahan data periode
    public function edit($id)
    {
        $periode = $this->periodeQueryServices->getOne($id);

        return view('admin.pages.master-data.periode.edit', compact('periode'));
    }

    public function update(PeriodeUpdateRequest $request, Periode $periode)
    {
        $this->periodeCommandServices->update($request, $periode);

        return redirect()->route('admin.master-data.periode.index')->with('success', 'Data berhasil diubah');
    }

    public function updateStatus($id)
    {
        try {
            DB::beginTransaction();
            $status = $this->periodeCommandServices->updateStatus($id);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengubah status debitur',
                'data' => $status,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status debitur',
            ]);
        }
    }

    // Penghapusan data periode
    public function delete(Periode $periode)
    {
        $this->periodeCommandServices->delete($periode);

        return redirect()->route('admin.master-data.periode.index')->with('success', 'Data berhasil dihapus');
    }

    // Datatable
    public function datatable(Request $request)
    {
        return $this->periodeDatatableServices->datatable($request);
    }
}
