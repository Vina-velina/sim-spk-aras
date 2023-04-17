<?php

namespace App\Services\Kategori;

use App\Models\KriteriaPenilaian;

class KategoriQueryServices
{
    public function getOne(string $id)
    {
        return KriteriaPenilaian::find($id);
    }

    public function getSubOne(KriteriaPenilaian $id)
    {
        dd($id);
        return KriteriaPenilaian::find($id)->subKriteriaPenilaian;
    }
}
