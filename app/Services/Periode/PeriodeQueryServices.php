<?php

namespace App\Services\Periode;

use App\Helpers\FormatDateToIndonesia;
use App\Models\Periode;

class PeriodeQueryServices
{
    public function getOne(string $id)
    {
        $periode = Periode::find($id);

        return $periode;
    }

    public function getAll()
    {
        return Periode::all();
    }
}
