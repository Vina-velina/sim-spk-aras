<?php

namespace App\Services\Kriteria;

use App\Http\Requests\Kriteria\KriteriaStoreRequest;
use App\Http\Requests\Kriteria\KriteriaUpdateRequest;
use App\Http\Requests\Kriteria\SubKriteriaStoreRequest;
use App\Http\Requests\Kriteria\SubKriteriaUpdateRequest;
use App\Models\KriteriaPenilaian;
use App\Models\SubKriteriaPenilaian;

class KriteriaCommandServices
{
    public function store(KriteriaStoreRequest $request)
    {
        $request->validated();

        $query = new KriteriaPenilaian();
        $query->id_periode = $request->id_periode;
        $query->id_master_kriteria = $request->id_master_kriteria;
        $query->bobot_kriteria = $request->bobot_kriteria;
        $query->jenis = $request->jenis_kriteria;
        $query->keterangan = $request->keterangan;
        $query->save();

        return $query;
    }

    public function update(KriteriaUpdateRequest $request, string $id_kriteria)
    {
        $query = KriteriaPenilaian::find($id_kriteria);

        $request->validated();

        $query->id_periode = $request->id_periode;
        $query->id_master_kriteria = $request->id_master_kriteria;
        $query->bobot_kriteria = $request->bobot_kriteria;
        $query->jenis = $request->jenis_kriteria;
        $query->status = $request->status;
        $query->keterangan = $request->keterangan;
        $query->save();

        return $query;
    }

    public function updateStatus(string $id_kriteria)
    {
        $query = KriteriaPenilaian::find($id_kriteria);
        $query->status = $query->status == 'aktif' ? 'nonaktif' : 'aktif';
        $query->save();

        return $query;
    }

    public function destroy(string $id_kriteria)
    {
        $query = KriteriaPenilaian::find($id_kriteria);
        $subKriteria = SubKriteriaPenilaian::where('id_kriteria', $query->id)->delete();
        $query->delete();

        return $query;
    }

    public function subStore(SubKriteriaStoreRequest $request, string $id_kriteria)
    {
        $request->validated();

        $query = new SubKriteriaPenilaian();
        $query->id_kriteria = $id_kriteria;
        $query->nama_sub_kriteria = $request->nama_sub_kriteria;
        $query->nilai_sub_kriteria = $request->nilai_sub_kriteria;
        $query->save();

        return $query;
    }

    public function subUpdate(SubKriteriaUpdateRequest $request, string $id_sub_kirteria)
    {
        $query = SubKriteriaPenilaian::find($id_sub_kirteria);

        $request->validated();

        $query->nama_sub_kriteria = $request->nama_sub_kriteria;
        $query->nilai_sub_kriteria = $request->nilai_sub_kriteria;
        $query->save();

        return $query;
    }

    public function subDestroy(string $id_sub_kriteria)
    {
        $subKriteria = SubKriteriaPenilaian::find($id_sub_kriteria);
        $subKriteria->delete();
    }
}
