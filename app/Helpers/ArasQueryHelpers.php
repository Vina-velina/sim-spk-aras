<?php

namespace App\Helpers;

use App\Models\Debitur;
use App\Models\KriteriaPenilaian;
use App\Models\Penilaian;
use App\Models\Periode;
use App\Services\HasilRekapan\HasilRekapanCommandService;

class ArasQueryHelpers
{
    public static function dss(string $id_periode)
    {
        // =================================================
        // Validasi Periode
        // =================================================
        // 1. Validasi Periode
        if (!isset($id_periode)) {
            throw new \Exception('Invalid Parameter');
        }

        // =================================================
        // Pembentukan Matriks Keputusan (X)
        // =================================================

        // 2. Mendefinisikan Matriks Keputusan X / Nilai Alternatif Kriteria
        $periode = Periode::where('id', $id_periode)->first();
        $alternatifs = Debitur::where('status', 'aktif')
            ->whereHas('userPeriode', function ($query) use ($id_periode) {
                $query->where('id_periode', $id_periode);
            })
            ->whereHas('penilaian', function ($query) use ($id_periode) {
                $query->where('id_periode', $id_periode);
            })
            ->orderBy('updated_at', 'DESC')
            ->get();

        if (count($alternatifs) <= 0) {
            throw new \Exception('Belum ada penilaian yang masuk');
        }

        $kriterias = KriteriaPenilaian::where('status', 'aktif')->where('id_periode', $periode->id)->orderBy('bobot_kriteria', 'DESC')->get();
        $matriks_x = [];
        foreach ($alternatifs as $alternatif) {
            foreach ($kriterias as $kriteria) {
                $id_alternatif = $alternatif->id;
                $id_kriteria = $kriteria->id;

                $data_pencocokan = Penilaian::where('id_periode', $periode->id)->where('id_kriteria', $id_kriteria)->where('id_debitur', $id_alternatif)->first();
                $nilai = $data_pencocokan->nilai;

                $matriks_x[$id_kriteria][$id_alternatif] = $nilai;
            }
        }
        // 3. Mendapatkan Nilai X0 Berdasarkan Matriks Keputusan X
        $matriks_x0 = [];
        foreach ($kriterias as $kriteria) {
            $type_kriteria = $kriteria->jenis;
            if ($type_kriteria == 'benefit') {
                $id_kriteria = $kriteria->id;
                $x0 = max($matriks_x[$id_kriteria]);
            } else {
                $id_kriteria = $kriteria->id;
                $x0 = min($matriks_x[$id_kriteria]);
            }
            $matriks_x0[$id_kriteria] = $x0;
        }

        // =================================================
        // Merumuskan Matriks Keputusan (X)
        // =================================================

        // 4. Mendapatkan Nilai Selain Nilai X0
        $matriks_x2 = [];
        foreach ($alternatifs as $alternatif) {
            foreach ($kriterias as $kriteria) {
                $id_alternatif = $alternatif->id;
                $id_kriteria = $kriteria->id;

                $x = $matriks_x[$id_kriteria][$id_alternatif];
                $type_kriteria = $kriteria->jenis;
                if ($type_kriteria == 'benefit') {
                    $x2 = $x;
                } else {
                    if ($x != 0) {
                        $x2 = 1 / $x;
                    } else {
                        $x2 = 0;
                    }
                }

                $matriks_x2[$id_kriteria][$id_alternatif] = $x2;
            }
        }

        // 5. Mendapatkan Nilai Normalisasi Untuk XO
        $matriks_x02 = [];
        foreach ($kriterias as $kriteria) {
            $id_kriteria = $kriteria->id;
            $type_kriteria = $kriteria->jenis;
            $x0 = $matriks_x0[$id_kriteria];
            if ($type_kriteria == 'benefit') {
                $x02 = $x0;
            } else {
                if ($x0 != 0) {
                    $x02 = 1 / $x0;
                } else {
                    $x02 = 0;
                }
            }

            $matriks_x02[$id_kriteria] = $x02;
        }

        // 6. Mendapatkan Nilai Total Matriks X , Digunakan Untuk Proses Normalisasi
        $total_matriks_x = [];
        foreach ($kriterias as $kriteria) {
            $tx = 0;
            $id_kriteria = $kriteria->id;
            foreach ($alternatifs as $alternatif) {
                $id_alternatif = $alternatif->id;
                $x = $matriks_x2[$id_kriteria][$id_alternatif];
                $tx += $x;
            }
            $x0 = $matriks_x02[$id_kriteria];
            $total_matriks_x[$id_kriteria] = $tx + $x0;
        }

        // =================================================
        // Matriks Normalisasi
        // =================================================

        // 7. Normalisasi Matriks Keputusan Selain X0
        $matriks_r = [];
        foreach ($alternatifs as $alternatif) {
            foreach ($kriterias as $kriteria) {
                $id_alternatif = $alternatif->id;
                $id_kriteria = $kriteria->id;

                $x = $matriks_x2[$id_kriteria][$id_alternatif];
                $total = $total_matriks_x[$id_kriteria];
                $matriks_r[$id_kriteria][$id_alternatif] = $x / $total;
            }
        }

        // 8. Normalisasi Matriks Keputusan Untuk X0
        $matriks_r0 = [];
        foreach ($kriterias as $kriteria) {
            $id_kriteria = $kriteria->id;
            $x0 = $matriks_x02[$id_kriteria];
            $total = $total_matriks_x[$id_kriteria];
            $matriks_r0[$id_kriteria] = $x0 / $total;
        }

        // =================================================
        // Matriks Normalisasi Terbobot
        // =================================================

        // 9. Membentuk Matriks Normalisasi Terbobot
        $matriks_rb = [];
        $total_rb = [];
        foreach ($alternatifs as $alternatif) {
            $t_rb = 0;
            $id_alternatif = $alternatif->id;
            foreach ($kriterias as $kriteria) {
                $id_kriteria = $kriteria->id;
                $bobot = $kriteria->bobot_kriteria / 100;
                $r = $matriks_r[$id_kriteria][$id_alternatif];
                $rb = $r * $bobot;
                $matriks_rb[$id_kriteria][$id_alternatif] = $rb;
                $t_rb += $rb;
            }
            $total_rb[$id_alternatif] = $t_rb;
        }

        // =================================================
        //  Perhitungan Nilai Akhir
        // =================================================

        // 10. Melakukan Perhitungan Nilai Akhir
        $matriks_rb0 = [];
        $total_rb0 = 0;
        foreach ($kriterias as $kriteria) {
            $id_kriteria = $kriteria->id;
            $r0 = $matriks_r0[$id_kriteria];
            $bobot = $kriteria->bobot_kriteria / 100;
            $rb = $r0 * $bobot;
            $matriks_rb0[$id_kriteria] = $rb;
            $total_rb0 += $rb;
        }

        // =================================================
        //  Hasil Akhir dan Store Ke Database
        // =================================================

        // 11. Hasil Akhir Perhitungan Tidak Termasuk Nilai X0
        $hasil_akhir = [];
        foreach ($alternatifs as $alternatif) {
            $id_alternatif = $alternatif->id;
            $total_rb[$id_alternatif];
            $nilai = $total_rb[$id_alternatif] / $total_rb0;

            $hasil_akhir[$id_alternatif] = $nilai;

            $obj = new HasilRekapanCommandService(); // Buat objek instan dari kelas
            $obj->storeRekomendasi($id_alternatif, $id_periode, $nilai);
        }

        // Hasil Akhir Untuk X0
        $hasil_akhir_rb0 = $total_rb0 / $total_rb0;

        // =================================================
        //  Return Data
        // =================================================
        // Prepare to return nilai, return as array

        $data_return = [
            'kriteria' => $kriterias,
            'alternatif' => $alternatifs,
            'pembentukan_matriks_x' => $matriks_x,
            'pembentukan_matriks_x0' => $matriks_x0,
            'merumuskan_matriks_x' => $matriks_x2,
            'merumuskan_matriks_x0' => $matriks_x02,
            'total_nilai_matriks' => $total_matriks_x,
            'normalisasi_matriks_x' => $matriks_r,
            'normalisasi_matriks_x0' => $matriks_r0,
            'normalisasi_terbobot' => $matriks_rb,
            'total_normalisasi_terbobot' => $total_rb,
            'perhitungan_nilai_akhir' => $matriks_rb0,
            'total_perhitungan_nilai_akhir' => $total_rb0,
            'hasil_akhir_x' => $hasil_akhir,
            'hasil_akhir_x0' => $hasil_akhir_rb0,
        ];

        // Tidak usah diuji
        return $data_return;
    }
}
