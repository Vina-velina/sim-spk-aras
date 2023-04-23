<?php

namespace App\Services\Kriteria;

use App\Http\Requests\Kriteria\KriteriaStoreRequest;
use App\Http\Requests\Kriteria\KriteriaUpdateRequest;
use App\Http\Requests\Kriteria\SubKriteriaStoreRequest;
use App\Http\Requests\Kriteria\SubKriteriaUpdateRequest;
use App\Models\KriteriaPenilaian;
use App\Models\SubKriteriaPenilaian;
use Ramsey\Uuid\Uuid;

class KriteriaCommandServices
{
    public function store(KriteriaStoreRequest $request)
    {
        $request->validated();

        $kriteria = KriteriaPenilaian::create([
            'id_periode' => $request->id_periode,
            'id_master_kriteria' => $request->id_master_kriteria,
            'bobot_kriteria' => $request->bobot_kriteria,
            'keterangan' => $request->keterangan,
        ]);

        return $kriteria;
    }

    public function update(KriteriaUpdateRequest $request, KriteriaPenilaian $kriteria)
    {
        $request->validated();

        $kriteria->id_periode = $request->id_periode;
        $kriteria->id_master_kriteria = $request->id_master_kriteria;
        $kriteria->bobot_kriteria = $request->bobot_kriteria;
        $kriteria->keterangan = $request->keterangan;
        $kriteria->save();

        return $kriteria;
    }

    public function updateStatus(KriteriaPenilaian $kriteria)
    {
        $kriteria->status = $kriteria->status == 'aktif' ? 'nonaktif' : 'aktif';
        $kriteria->save();

        return $kriteria;
    }

    public function destroy(KriteriaPenilaian $kriteria)
    {
        $kriteria->delete();
    }

    public function subStore(KriteriaPenilaian $kriteria, SubKriteriaStoreRequest $request)
    {
        $request->validated();

        $subKriteria = SubKriteriaPenilaian::create([
            'id' => Uuid::uuid4(),
            'id_kriteria' => $kriteria->id,
            'nama_sub_kriteria' => $request->nama_sub_kriteria,
            'nilai_sub_kriteria' => $request->nilai_sub_kriteria,
        ]);

        return $subKriteria;
    }

    public function subUpdate(SubKriteriaPenilaian $subKriteria, SubKriteriaUpdateRequest $request)
    {
        $request->validated();

        $subKriteria->nama_sub_kriteria = $request->nama_sub_kriteria;
        $subKriteria->nilai_sub_kriteria = $request->nilai_sub_kriteria;
        $subKriteria->save();

        return $subKriteria;
    }

    public function subDestroy(SubKriteriaPenilaian $subKriteria)
    {
        $subKriteria->delete();
    }
}
