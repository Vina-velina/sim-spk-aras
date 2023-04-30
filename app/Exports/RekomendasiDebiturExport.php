<?php

namespace App\Exports;

use App\Models\RekomendasiDebitur;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekomendasiDebiturExport implements FromQuery, WithTitle, WithHeadings, WithStyles, ShouldAutoSize, WithEvents, WithMapping
{
    protected $id_periode;

    public function __construct($id_periode)
    {
        $this->id_periode = $id_periode;
    }

    public function query()
    {
        $data_debitur = RekomendasiDebitur::query();
        $data_debitur->where('id_periode', $this->id_periode);
        $data_debitur->orderBy('ranking', 'asc');
        $data_debitur->get();

        return $data_debitur;
    }

    public function title(): string
    {
        return 'Data Rekomendasi Debitur';
    }

    public function map($item): array
    {
        return [
            $item->debitur->nama,
            $item->debitur->alamat,
            $item->ranking,
            $item->nilai_aras,
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
                $lastCell = $highestColumn . $highestRow;
                $rangeCell = 'A1:' . $lastCell;
                $event->sheet->getDelegate()->getStyle($rangeCell)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
            },
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Debitur',
            'Alamat Debitur',
            'Ranking',
            'Nilai Aras',
        ];
    }
}
