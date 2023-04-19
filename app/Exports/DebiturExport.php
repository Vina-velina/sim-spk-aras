<?php

namespace App\Exports;

use App\Models\Debitur;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DebiturExport implements FromQuery, WithTitle, WithHeadings, WithStyles, ShouldAutoSize, WithMapping
{
    protected $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function query()
    {
        $data_debitur = Debitur::query();
        if (isset($this->status)) {
            if ($this->status != 'semua') {
                $data_debitur->where('status', $this->status);
            }
        }
        $data_debitur->get();

        return $data_debitur;
    }

    public function title(): string
    {
        return 'Data Debitur';
    }

    public function map($item): array
    {
        return [
            $item->nama,
            $item->alamat,
            $item->pekerjaan,
            $item->no_telp,
            $item->no_ktp,
            $item->status,
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
            'Pekerjaan',
            'Nomor Telepon',
            'Nomor KTP',
            'Status Aktif',
        ];
    }
}
