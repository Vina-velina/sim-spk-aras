<?php

namespace App\Services\Kriteria;

use App\Models\KriteriaPenilaian;
use App\Models\SubKriteriaPenilaian;

class KriteriaQueryServices
{
    public function getOne(string $id)
    {
        return KriteriaPenilaian::find($id);
    }

    public function getByIdPeriode(string $id)
    {
        return KriteriaPenilaian::where('id_periode', $id)->orderBy('updated_at', 'desc')->get();
    }

    public function getByIdPeriodeWhereAktif(string $id)
    {
        return KriteriaPenilaian::where('id_periode', $id)->where('status', 'aktif')->orderBy('updated_at', 'desc')->get();
    }

    public function getAll()
    {
        return KriteriaPenilaian::orderBy('updated_at', 'desc')->get();
    }

    public function getSubKriteriaById(string $id)
    {
        return SubKriteriaPenilaian::where('id', $id)->first();
    }
}
