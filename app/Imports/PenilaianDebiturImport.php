<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PenilaianDebiturImport implements ToModel, WithStartRow, WithValidation
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
