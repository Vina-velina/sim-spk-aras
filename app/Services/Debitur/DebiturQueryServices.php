<?php

namespace App\Services\Debitur;

use App\Models\Debitur;

class DebiturQueryServices
{
    public function getOne(string $id)
    {
        return Debitur::find($id);
    }

    public function getOneWhereAktif(string $id)
    {
        return Debitur::where('id', $id)->where('status', 'aktif')->firstOrFail();
    }

    public function getTotaldebitur()
    {
        return Debitur::all()->count();
    }

    public function getAll()
    {
        return Debitur::where('status', 'aktif')->get();
    }
}
