<?php

namespace App\Imports;

use App\Imports\PenilaianSheet\SheetDebiturImport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PenilaianDebiturImport implements WithMultipleSheets
{
    protected $id_periode;

    public function __construct($id_periode)
    {
        $this->id_periode = $id_periode;
    }

    public function sheets(): array
    {
        return [
            'Penilaian Debitur' => new SheetDebiturImport($this->id_periode),
        ];
    }
}
