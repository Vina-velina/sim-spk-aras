<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FormatDateToIndonesia;
use App\Http\Controllers\Controller;
use App\Http\Requests\Periode\PeriodeStoreRequest;
use App\Http\Requests\Periode\PeriodeUpdateRequest;
use App\Services\Debitur\DebiturQueryServices;
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

    protected $debiturQueryServices;

    public function __construct(
        PeriodeQueryServices $periodeQueryServices,
        PeriodeDatatableServices $periodeDatatableServices,
        PeriodeCommandServices $periodeCommandServices,
        DebiturQueryServices $debiturQueryServices
    ) {
        $this->periodeCommandServices = $periodeCommandServices;
        $this->periodeDatatableServices = $periodeDatatableServices;
        $this->periodeQueryServices = $periodeQueryServices;
        $this->debiturQueryServices = $debiturQueryServices;
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

            $detail->tgl_awal_penilaian = FormatDateToIndonesia::getIndonesiaDateTime($detail->tgl_awal_penilaian);
            $detail->tgl_akhir_penilaian = FormatDateToIndonesia::getIndonesiaDateTime($detail->tgl_akhir_penilaian);
            $listUser = $detail->userPeriode;
            $user_periode = '';
            foreach ($listUser as  $index => $item) {
                $user_periode .= '<span class="badge bg-info ml-1">' . $item->debitur->nama . ' - ' . $item->debitur->alamat . '</span>';
            }

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Didapatkan',
                'data' => $detail,
                'userPeriode' => $user_periode
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    // Penambahan data periode
    public function create()
    {
        $debiturs = $this->debiturQueryServices->getAll();
        return view('admin.pages.master-data.periode.create', compact('debiturs'));
    }

    public function store(PeriodeStoreRequest $request)
    {
        try {
            // check jika periode yang di buat memiliki range tgl mulai - tgl akhir yang beririsan dengan periode yang sudah ada
            $allPeriode = $this->periodeQueryServices->getAll();

            for ($i = 0; $i < count($allPeriode); $i++) {
                // convert tgl awal dan tgl akhir periode yang sudah ada ke format timestamp
                $tglawallain = strtotime($allPeriode[$i]->tgl_awal_penilaian);
                $tglakhirlain = strtotime($allPeriode[$i]->tgl_akhir_penilaian);
                $tglawalrequest = strtotime($request->tgl_awal_penilaian);
                $tglakhirrequest = strtotime($request->tgl_akhir_penilaian);

                // tgl awal dan akhir periode yang di buat tidak boleh berada pada range tgl awal - akhir periode yang sudah ada atau rage periode yang di buat tidak beririsan dengan periode yang sudah ada
                if ($tglawalrequest >= $tglawallain && $tglawalrequest <= $tglakhirlain) {
                    return to_route('admin.master-data.periode.create')->with('error', 'Data gagal disimpan, periode yang di buat memiliki range tanggal mulai - tanggal akhir yang beririsan dengan periode yang sudah ada');
                } elseif ($tglakhirrequest >= $tglawallain && $tglakhirrequest <= $tglakhirlain) {
                    return to_route('admin.master-data.periode.create')->with('error', 'Data gagal disimpan, periode yang di buat memiliki range tanggal mulai - tanggal akhir yang beririsan dengan periode yang sudah ada');
                } elseif ($tglawalrequest <= $tglawallain && $tglakhirrequest >= $tglakhirlain) {
                    return to_route('admin.master-data.periode.create')->with('error', 'Data gagal disimpan, periode yang di buat memiliki range tanggal mulai - tanggal akhir yang beririsan dengan periode yang sudah ada');
                } elseif ($tglawalrequest >= $tglawallain && $tglakhirrequest <= $tglakhirlain) {
                    return to_route('admin.master-data.periode.create')->with('error', 'Data gagal disimpan, periode yang di buat memiliki range tanggal mulai - tanggal akhir yang beririsan dengan periode yang sudah ada');
                } elseif ($tglawalrequest == $tglawallain && $tglakhirrequest == $tglakhirlain) {
                    return to_route('admin.master-data.periode.create')->with('error', 'Data gagal disimpan, periode yang di buat memiliki range tanggal mulai - tanggal akhir yang beririsan dengan periode yang sudah ada');
                }
            }

            DB::beginTransaction();
            $this->periodeCommandServices->store($request);
            DB::commit();

            return to_route('admin.master-data.periode.index')->with('success', 'Data berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();

            return to_route('admin.master-data.periode.index')->with('error', $th->getMessage());
        }
    }

    // Pengubahan data periode
    public function edit($id)
    {
        $periode = $this->periodeQueryServices->getOne($id);
        $debiturs = $this->debiturQueryServices->getAll();
        $user_periode = $this->periodeQueryServices->getDebiturInPeriode($id);
        return view('admin.pages.master-data.periode.edit', compact('periode', 'debiturs', 'user_periode'));
    }

    public function update(PeriodeUpdateRequest $request, string $id)
    {
        try {
            $allPeriode = $this->periodeQueryServices->getAllNotInclude($id);

            for ($i = 0; $i < count($allPeriode); $i++) {
                // check jika saat ini bukan periode yang sedang di edit
                if ($allPeriode[$i]->id != $id) {
                    // convert tgl awal dan tgl akhir periode yang sudah ada ke format timestamp
                    $tglawallain = strtotime($allPeriode[$i]->tgl_awal_penilaian);
                    $tglakhirlain = strtotime($allPeriode[$i]->tgl_akhir_penilaian);
                    $tglawalrequest = strtotime($request->tgl_awal_penilaian);
                    $tglakhirrequest = strtotime($request->tgl_akhir_penilaian);

                    // tgl awal dan akhir periode yang di buat tidak boleh berada pada range tgl awal - akhir periode yang sudah ada
                    if ($tglawalrequest >= $tglawallain && $tglawalrequest <= $tglakhirlain) {
                        return to_route('admin.master-data.periode.edit', $id)->with('error', 'Data gagal diperbaharui, periode yang di edit memiliki range tanggal mulai - tanggal akhir yang beririsan dengan periode yang sudah ada');
                    } elseif ($tglakhirrequest >= $tglawallain && $tglakhirrequest <= $tglakhirlain) {
                        return to_route('admin.master-data.periode.edit', $id)->with('error', 'Data gagal diperbaharui, periode yang di edit memiliki range tanggal mulai - tanggal akhir yang beririsan dengan periode yang sudah ada');
                    } elseif ($tglawalrequest <= $tglawallain && $tglakhirrequest >= $tglakhirlain) {
                        return to_route('admin.master-data.periode.edit', $id)->with('error', 'Data gagal diperbaharui, periode yang di edit memiliki range tanggal mulai - tanggal akhir yang beririsan dengan periode yang sudah ada');
                    } elseif ($tglawalrequest >= $tglawallain && $tglakhirrequest <= $tglakhirlain) {
                        return to_route('admin.master-data.periode.edit', $id)->with('error', 'Data gagal diperbaharui, periode yang di edit memiliki range tanggal mulai - tanggal akhir yang beririsan dengan periode yang sudah ada');
                    } elseif ($tglawalrequest == $tglawallain && $tglakhirrequest == $tglakhirlain) {
                        return to_route('admin.master-data.periode.edit', $id)->with('error', 'Data gagal diperbaharui, periode yang di edit memiliki range tanggal mulai - tanggal akhir yang beririsan dengan periode yang sudah ada');
                    }
                }
            }

            DB::beginTransaction();
            $this->periodeCommandServices->update($request, $id);
            DB::commit();

            return to_route('admin.master-data.periode.index')->with('success', 'Data berhasil diperbaharui');
        } catch (\Throwable $th) {
            DB::rollBack();

            return to_route('admin.master-data.periode.index')->with('error', $th->getMessage());
        }
    }

    public function updateStatus(string $id)
    {
        try {
            DB::beginTransaction();
            $status = $this->periodeCommandServices->updateStatus($id);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbaharui',
                'data' => $status,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    // Penghapusan data periode
    public function delete(string $id)
    {
        $this->periodeCommandServices->delete($id);

        return to_route('admin.master-data.periode.index')->with('success', 'Data berhasil dihapus');
    }

    // Datatable
    public function datatable(Request $request)
    {
        return $this->periodeDatatableServices->datatable($request);
    }
}
