<?php

namespace App\Services\MasterKriteria;

use App\Models\MasterKriteriaPenilaian;

class MasterKriteriaQueryServices
{
    public function getOne(string $id)
    {
        return MasterKriteriaPenilaian::findOrFail($id);
    }

    public function getAll()
    {
        return MasterKriteriaPenilaian::orderBy('updated_at', 'desc')->get();
    }

    public function getTotalMasterKriteria()
    {
        return MasterKriteriaPenilaian::all()->count();
    }
}
