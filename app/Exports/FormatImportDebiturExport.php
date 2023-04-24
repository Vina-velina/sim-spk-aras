<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class FormatImportDebiturExport implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize
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
