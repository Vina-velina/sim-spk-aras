<?php

namespace App\Services\Kategori;

use App\Models\KriteriaPenilaian;
use App\Models\SubKriteriaPenilaian;

class KategoriQueryServices
{
    public function getOne(string $id)
    {
        return KriteriaPenilaian::find($id);
    }

    public function getByIdPeriode(string $id)
    {
        return KriteriaPenilaian::where('id_periode', $id)->get();
    }

    public function getAll()
    {
        return KriteriaPenilaian::all();
    }

    public function getSubKriteriaById(string $id)
    {
        return SubKriteriaPenilaian::where('id', $id)->get()->first();
    }
}
