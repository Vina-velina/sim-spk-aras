<?php

namespace App\Services\HasilRekapan;

use App\Models\DebiturTerpilih;
use App\Models\RekomendasiDebitur;

class HasilRekapanQueryService
{
    public function getRekomendasiByPeriode(string $id_periode)
    {
        $rekomendasi = RekomendasiDebitur::where('id_periode', $id_periode)->orderBy('nilai_aras', 'DESC')->get();

        $data = [];

        foreach ($rekomendasi as $item) {
            $find_in_terpilih = DebiturTerpilih::where('id_periode', $id_periode)->where('id_debitur', $item->id_debitur)->first();
            if (! isset($find_in_terpilih)) {
                array_push($data, ['id' => $item->id, 'text' => $item->debitur->nama.' | Ranking '.$item->ranking]);
            }
        }

        return $data;
    }
}
