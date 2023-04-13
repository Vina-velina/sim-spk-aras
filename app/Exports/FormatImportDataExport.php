<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FormatImportDataExport implements FromCollection, WithTitle, WithHeadings, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        $data_debitur = collect([
            [
                'nama_debitur' => 'Ketut Prayoga',
                'alamat_debitur' => 'Kaliasem',
                'pekerjaan' => 'Wiraswasta',
                'no_telp' => '81234567890',
                'no_ktp' => '5108062202990112',
                'status' => 'aktif',
                'notif' => '(Ini Adalah Contoh Pengisian Data, Hapus Baris Ini Sebelum Mengisi Data)',
            ],
        ]);

        return $data_debitur;
    }

    public function title(): string
    {
        return 'Data Debitur Baru';
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

    public function headings(): array
    {
        return [
            'Nama Debitur *',
            'Alamat Debitur *',
            'Pekerjaan',
            'Nomor Telepon',
            'Nomor KTP',
            'Status Aktif (Opsi: aktif/nonaktif) *',
        ];
    }
}
