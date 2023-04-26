<?php

namespace App\Services\HasilRekapan;

use App\Models\Periode;
use App\Models\RekomendasiDebitur;
use Illuminate\Support\Facades\Auth;

class HasilRekapanCommandService
{
    public function storeRekomendasi(string $id_debitur, string $id_periode, string $nilai)
    {
        // Create
        $query = new RekomendasiDebitur();
        $query->id_debitur = $id_debitur;
        $query->id_user = Auth::user()->id;
        $query->id_periode = $id_periode;
        $query->ranking = 0;
        $query->nilai_aras = $nilai;
        $query->save();

        return $query;
    }

    public function updateOrder(string $id_periode)
    {
        Periode::find($id_periode);

        $rekomendasi = RekomendasiDebitur::where('id_periode', $id_periode)->orderBy('nilai_aras', 'DESC')->get();
        foreach ($rekomendasi as $index => $data) {
            $data->ranking = $index + 1;
            $data->save();
        }

        return $rekomendasi;
    }

    public function deleteRekomendasi(string $id_periode)
    {
        $delete = RekomendasiDebitur::where('id_periode', $id_periode)->delete();

        return $delete;
    }
}
