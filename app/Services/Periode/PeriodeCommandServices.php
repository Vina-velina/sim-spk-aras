<?php

namespace App\Services\Periode;

use App\Http\Requests\Periode\PeriodeStoreRequest;
use App\Http\Requests\Periode\PeriodeUpdateRequest;
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

    public function update(PeriodeUpdateRequest $request, Periode $periode)
    {
        $request->validated();
        $periode->nama_periode = $request->nama_periode;
        $periode->keterangan = $request->keterangan;
        $periode->tgl_awal_penilaian = $request->tgl_awal_penilaian;
        $periode->tgl_akhir_penilaian = $request->tgl_akhir_penilaian;
        $periode->status = $periode->status;
        $periode->save();

        return $periode;
    }

    public function updateStatus($id)
    {
        $query = Periode::find($id);
        $query->status = $query->status == 'aktif' ? 'nonaktif' : 'aktif';
        $query->save();

        return $query;
    }

    public function delete(Periode $periode)
    {
        $periode->delete();
    }
}
