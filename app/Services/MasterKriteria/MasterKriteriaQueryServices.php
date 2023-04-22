<?php

namespace App\Services\MasterKriteria;

use App\Models\MasterKriteriaPenilaian;

class MasterKriteriaQueryServices
{
    public function getOne(string $id)
    {
        return MasterKriteriaPenilaian::find($id);
    }

    public function getAll()
    {
        return MasterKriteriaPenilaian::all();
    }
}
