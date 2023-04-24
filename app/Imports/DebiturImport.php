<?php

namespace App\Imports;

use App\Models\Debitur;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DebiturImport implements ToModel, WithStartRow, WithValidation
{
    use Importable;

    protected $rowError;

    public function __construct()
    {
        $this->rowError = 2;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        if (isset($row[4])) {
            $find_ktp = Debitur::where('no_ktp', $row[4])->first();
            if ($find_ktp) {
                throw new \Exception('Nomor KTP Sudah Digunakan Untuk Data Pada Kolom Ke-'.$this->rowError);
            }
        }

        if (isset($row[3])) {
            $find_ktp = Debitur::where('no_telp', $row[3])->first();
            if ($find_ktp) {
                throw new \Exception('Nomor Telepon Sudah Digunakan Untuk Data Pada Kolom Ke-'.$this->rowError);
            }
        }

        $data_debitur = Debitur::create([
            'nama' => $row[0],
            'alamat' => $row[1],
            'pekerjaan' => $row[2],
            'no_telp' => $row[3],
            'no_ktp' => $row[4],
            'status' => $row[5],
        ]);

        return $data_debitur;
    }

    public function rules(): array
    {
        return [
            '0' => 'required|string|max:255',
            '1' => 'required|string|max:500',
            '2' => 'nullable|string|max:255',
            '3' => ['nullable', 'numeric', 'digits_between:10,13', Rule::phone()->detect()->country('ID')],
            '4' => 'nullable|numeric|digits_between:10,16',
            '5' => 'nullable|in:aktif,nonaktif',
        ];
    }

    public function customValidationAttributes()
    {
        return [
            '0' => 'Nama Debitur',
            '1' => 'Alamat Debitur',
            '2' => 'Pekerjaan Debitur',
            '3' => 'Nomor Telepon',
            '4' => 'Nomor KTP',
            '5' => 'Status Aktif',
        ];
    }
}
