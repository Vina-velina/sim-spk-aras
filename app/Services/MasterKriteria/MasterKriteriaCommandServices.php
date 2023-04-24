<?php

namespace App\Services\MasterKriteria;

use App\Http\Requests\MasterKriteria\MasterKriteriaStoreRequest;
use App\Http\Requests\MasterKriteria\MasterKriteriaUpdateRequest;
use App\Models\MasterKriteriaPenilaian;

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

    public function update(MasterKriteriaUpdateRequest $request, string $id)
    {
        $query = MasterKriteriaPenilaian::findOrFail($id);

        $request->validated();

        $query->nama_kriteria = $request->nama_kriteria;
        $query->keterangan = $request->keterangan;
        $query->save();

        return $query;
    }

    public function destroy(string $id)
    {
        $query = MasterKriteriaPenilaian::findOrFail($id);
        $query->delete();
    }
}
