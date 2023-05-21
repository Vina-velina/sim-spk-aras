<?php

namespace App\Imports\PenilaianSheet;

use App\Models\Debitur;
use App\Models\KriteriaPenilaian;
use App\Models\Penilaian;
use App\Models\Periode;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SheetDebiturImport implements ToModel, WithStartRow, WithValidation
{
    use Importable;

    protected $rowError;

    protected $id_periode;

    public function __construct($id_periode)
    {
        $this->id_periode = $id_periode;
        $this->rowError = 2;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        // Cek apakah id_periode yang dikirim sesuai dengan id_periode pada excel
        if ($this->id_periode != $row[0]) {
            throw new \Exception('Periode Tidak Sesuai, Pastikan Anda Mengimport Data Pada Periode Penilaian Yang Sesuai');
        }

        // Cek apakah id periode ada di database
        $check_if_exist_in_periode = Periode::where('id', $row[0])->where('status', 'aktif')->first();
        if (!isset($check_if_exist_in_periode)) {
            throw new \Exception('Periode Tidak Ditemukan');
        }

        // Cek apakah periode penilaian masih aktif
        if (Carbon::now()->format('Y-m-d H:i:s') < $check_if_exist_in_periode->tgl_awal_penilaian || Carbon::now()->format('Y-m-d H:i:s') > $check_if_exist_in_periode->tgl_akhir_penilaian) {
            throw new \Exception('Periode Penilaian Debitur Telah Usai/Belum Dimulai');
        }

        // Cek apakah debitur ada
        $check_if_exist_debitur = Debitur::where('id', $row[1])->where('status', 'aktif')->first();
        if (!isset($check_if_exist_debitur)) {
            throw new \Exception('Debitur Tidak Ditemukan Pada Data Baris Ke-' . $this->rowError);
        }

        // Query untuk get kriteria
        $kriteriaData = KriteriaPenilaian::query()
            ->select('kriteria_penilaians.nama_kriteria')
            ->where('kriteria_penilaians.id_periode', $this->id_periode)
            ->where('kriteria_penilaians.status', 'aktif')
            ->orderBy('kriteria_penilaians.bobot_kriteria', 'DESC')
            ->get();

        $delete_all_penilaian = Penilaian::where('id_periode', $this->id_periode)->where('id_debitur', $row[1])->delete();

        // Start index dari 4
        $start_index = 4;
        foreach ($kriteriaData as $kriteria) {
            $check_if_exist_in_kriteria = KriteriaPenilaian::where('id', $row[$start_index])->where('status', 'aktif')->first();

            if (!isset($check_if_exist_in_kriteria)) {
                throw new \Exception('Kriteria Tidak Ditemukan Pada Data Baris Ke-' . $this->rowError);
            }

            $query = new Penilaian();
            $query->id_periode = $row[0];
            $query->id_debitur = $row[1];
            $query->id_kriteria = $row[$start_index];
            $query->nilai = $row[$start_index + 1];
            $query->save();

            $start_index += 2;
        }

        $this->rowError += 1;

        return $query;
    }

    public function rules(): array
    {
        $kriteriaData = KriteriaPenilaian::query()
            ->select('kriteria_penilaians.nama_kriteria')
            ->where('kriteria_penilaians.id_periode', $this->id_periode)
            ->where('kriteria_penilaians.status', 'aktif')
            ->orderBy('kriteria_penilaians.bobot_kriteria', 'DESC')
            ->get();

        $validation = [
            '0' => 'required|uuid',
            '1' => 'required|uuid',
            '2' => 'required|string|max:191',
            '3' => 'required|string|max:255',
        ];

        $start_index = 4;
        foreach ($kriteriaData as $kriteria) {
            // Menambahkan aturan validasi baru pada indeks yang ditentukan
            $validation[$start_index] = 'required|uuid';
            $validation[$start_index + 1] = 'required|numeric';
            $start_index += 2;
        }

        return $validation;
    }

    public function customValidationAttributes()
    {
        $kriteriaData = KriteriaPenilaian::query()
            ->select('kriteria_penilaians.nama_kriteria')
            ->where('kriteria_penilaians.id_periode', $this->id_periode)
            ->where('kriteria_penilaians.status', 'aktif')
            ->orderBy('kriteria_penilaians.bobot_kriteria', 'DESC')
            ->get();

        $validation = [
            '0' => 'Id Periode',
            '1' => 'Id Debitur',
            '2' => 'Nama Debitur',
            '3' => 'Alamat Debitur',
        ];

        $start_index = 4;
        foreach ($kriteriaData as $kriteria) {
            // Menambahkan aturan validasi baru pada indeks yang ditentukan
            $validation[$start_index] = 'Id Kriteria ' . $kriteria->nama_kriteria;
            $validation[$start_index + 1] = 'Nilai Kriteria ' . $kriteria->nama_kriteria;
            $start_index += 2;
        }

        return $validation;
    }
}
