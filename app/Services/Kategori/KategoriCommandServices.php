<?php

namespace App\Services\Kategori;

use App\Http\Requests\Kategori\KategoriStoreRequest;
use App\Http\Requests\Kategori\KategoriUpdateRequest;
use App\Http\Requests\Kategori\SubKategoriStoreRequest;
use App\Http\Requests\Kategori\SubKategoriUpdateRequest;
use App\Models\KriteriaPenilaian;
use App\Models\SubKriteriaPenilaian;
use Ramsey\Uuid\Uuid;

class KategoriCommandServices
{
    public function store(KategoriStoreRequest $request)
    {
        $request->validated();

        $kriteria = KriteriaPenilaian::create([
            'nama_kriteria' => $request->nama_kriteria,
            'bobot_kriteria' => $request->bobot_kriteria,
            'keterangan' => $request->keterangan,
        ]);

        return $kriteria;
    }

    public function update(KategoriUpdateRequest $request, KriteriaPenilaian $kriteria)
    {
        $request->validated();

        $kriteria->nama_kriteria = $request->nama_kriteria;
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

    public function subStore(KriteriaPenilaian $kriteria, SubKategoriStoreRequest $request)
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

    public function subUpdate(SubKriteriaPenilaian $subKriteria, SubKategoriUpdateRequest $request)
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
