<?php

namespace App\Exports;

use App\Exports\PenilaianSheet\SheetDebiturExport;
use App\Exports\PenilaianSheet\SheetPeriodeExport;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FormatImportPenilaianExport implements WithMultipleSheets
{
    use Exportable;

    protected $id_periode;

    public function __construct($id_periode)
    {
        $this->id_periode = $id_periode;
    }

    public function sheets(): array
    {
        $periode = new SheetPeriodeExport($this->id_periode);
        $debitur = new SheetDebiturExport($this->id_periode);

        // Order Sheet
        $sheets = [$debitur, $periode];

        return $sheets;
    }
}
