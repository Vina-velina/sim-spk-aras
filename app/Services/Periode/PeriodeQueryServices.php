<?php

namespace App\Services\Periode;

use App\Models\Periode;

class PeriodeQueryServices
{
    public function getOne(string $id)
    {
        $periode = Periode::findOrFail($id);

        return $periode;
    }

    public function getAll()
    {
        return Periode::all();
    }

    public function getOneWhereAktif(string $id)
    {
        $periode = Periode::where('id', $id)->where('status', 'aktif')->firstOrFail();

        return $periode;
    }
}
