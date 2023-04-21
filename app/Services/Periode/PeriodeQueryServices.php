<?php

namespace App\Services\Periode;

use App\Helpers\FormatDateToIndonesia;
use App\Models\Periode;
use Carbon\Carbon;

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
}
