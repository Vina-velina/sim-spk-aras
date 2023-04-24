<?php

namespace App\Exports\PenilaianSheet;

use App\Models\Periode;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SheetPeriodeExport implements FromQuery, WithTitle, WithHeadings, WithStyles, ShouldAutoSize, WithEvents, WithMapping
{
    protected $id_periode;

    public function __construct($id_periode)
    {
        $this->id_periode = $id_periode;
    }

    public function query()
    {
        $query = Periode::query();
        $query->where('id', $this->id_periode);

        return $query;
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->nama_periode,
            $item->keterangan,
            $item->tgl_awal_penilaian,
            $item->tgl_akhir_penilaian,
            $item->status,
            $item->updated_at,
        ];
    }

    public function title(): string
    {
        return 'Informasi Periode';
    }

    public function headings(): array
    {
        return [
            'Id Periode',
            'Nama Periode',
            'Keterangan',
            'Tgl Awal Penilaian',
            'Tgl Akhir Penilaian',
            'Status',
            'Update Terakhir',

        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'alignment' => ['horizontal' => 'center', 'vertical' => 'center']],
        ];
    }

    public function registerEvents(): array
    {
        return [
            // Handle by a closure.
            AfterSheet::class => function (AfterSheet $event) {
                $highestRow = $event->sheet->getHighestRow();
                $highestColumn = $event->sheet->getHighestColumn();
                $lastCell = $highestColumn.$highestRow;
                $rangeCell = 'A1:'.$lastCell;
                $event->sheet->getDelegate()->getStyle($rangeCell)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            },
        ];
    }
}
