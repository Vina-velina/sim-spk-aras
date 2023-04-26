<?php

namespace App\Services\Periode;

use App\Http\Requests\Periode\PeriodeStoreRequest;
use App\Http\Requests\Periode\PeriodeUpdateRequest;
use App\Models\DebiturTerpilih;
use App\Models\Periode;

class PeriodeCommandServices
{
    public function store(PeriodeStoreRequest $request)
    {
        $request->validated();
        $query = new Periode();
        $query->nama_periode = $request->nama_periode;
        $query->keterangan = $request->keterangan;
        $query->tgl_awal_penilaian = $request->tgl_awal_penilaian;
        $query->tgl_akhir_penilaian = $request->tgl_akhir_penilaian;
        $query->status = 'aktif';
        $query->save();

        return $query;
    }

    public function update(PeriodeUpdateRequest $request, string $id)
    {
        $query = Periode::find($id);
        $request->validated();
        $query->nama_periode = $request->nama_periode;
        $query->keterangan = $request->keterangan;
        $query->tgl_awal_penilaian = $request->tgl_awal_penilaian;
        $query->tgl_akhir_penilaian = $request->tgl_akhir_penilaian;
        $query->status = $query->status;
        $query->save();

        return $query;
    }

    public function updateStatus(string $id)
    {
        $query = Periode::find($id);
        $query->status = $query->status == 'aktif' ? 'nonaktif' : 'aktif';
        $query->save();

        $find_debitur_terpilih = DebiturTerpilih::where('id_periode', $id)->get();
        foreach ($find_debitur_terpilih as $item) {
            $item->status = "draft";
            $item->save();
        }

        return $query;
    }

    public function delete(string $id)
    {
        $query = Periode::find($id);
        $query->delete();
    }
}
