<?php

namespace App\Services\Debitur;

use App\Models\Debitur;

class DebiturQueryServices
{

    public function getOne(string $id)
    {
        return $query = Debitur::find($id);
    }
}
