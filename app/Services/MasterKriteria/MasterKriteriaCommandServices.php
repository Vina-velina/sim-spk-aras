<?php

namespace App\Services\MasterKriteria;

use App\Http\Requests\MasterKriteria\MasterKriteriaStoreRequest;
use App\Http\Requests\MasterKriteria\MasterKriteriaUpdateRequest;
use App\Models\MasterKriteriaPenilaian;
use GuzzleHttp\Psr7\Request;

class MasterKriteriaCommandServices
{
    public function store(MasterKriteriaStoreRequest $request)
    {
        $request->validated();

        $kriteria = MasterKriteriaPenilaian::create([
            'nama_kriteria' => $request->nama_kriteria,
            'keterangan' => $request->keterangan,
        ]);

        return $kriteria;
    }

    public function update(MasterKriteriaUpdateRequest $request, MasterKriteriaPenilaian $kriteria)
    {
        $request->validated();

        $kriteria->nama_kriteria = $request->nama_kriteria;
        $kriteria->keterangan = $request->keterangan;
        $kriteria->save();

        return $kriteria;
    }

    public function destroy(MasterKriteriaPenilaian $kriteria)
    {
        $kriteria->delete();
    }
}
