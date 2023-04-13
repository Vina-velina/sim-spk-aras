<?php

namespace App\Services\Periode;

use App\Helpers\FormatDateToIndonesia;
use App\Models\Periode;

class PeriodeQueryServices
{
    public function getOne(string $id)
    {
        $periode = Periode::find($id);

        $periode->tgl_awal_penilaian = FormatDateToIndonesia::getIndonesiaDate($periode->tgl_awal_penilaian);
        $periode->tgl_akhir_penilaian = FormatDateToIndonesia::getIndonesiaDate($periode->tgl_akhir_penilaian);
        $periode->tgl_pengumuman = FormatDateToIndonesia::getIndonesiaDate($periode->tgl_pengumuman);

        return $periode;
    }
}
