<?php

namespace App\Services\HasilRekapan;

use App\Http\Requests\Rekapan\StoreDebiturTerpilihRequest;
use App\Models\DebiturTerpilih;
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

    public function storeTerpilih(StoreDebiturTerpilihRequest $request, string $id_periode)
    {
        $find_periode = Periode::where('id', $id_periode)->where('status', 'aktif')->firstOrFail();

        $find_rekomendasi = RekomendasiDebitur::where('id', $request->debitur)->firstOrFail();

        $if_exist_terpilih = DebiturTerpilih::where('id_periode', $find_periode->id)->where('id_debitur', $find_rekomendasi->id_debitur)->first();
        if ($if_exist_terpilih) {
            throw new \Exception('Debitur Ini Sudah Ada Pada Database Debitur Terpilih');
        }

        $query = new DebiturTerpilih();
        $query->id_periode = $find_periode->id;
        $query->id_user = Auth::user()->id;
        $query->id_debitur = $find_rekomendasi->id_debitur;
        $query->ranking = $find_rekomendasi->ranking;
        $query->nilai_aras = $find_rekomendasi->nilai_aras;
        $query->status = 'draft';
        $query->save();

        return $query;
    }

    public function deleteTerpilih(string $id_periode, string $id_terpilih)
    {
        $find_periode = Periode::where('id', $id_periode)->where('status', 'aktif')->firstOrFail();

        $find_terpilih = DebiturTerpilih::where('id', $id_terpilih)->where('id_periode', $find_periode->id)->delete();

        return $find_terpilih;
    }

    public function publishTerpilih(string $id_periode)
    {
        $find_periode = Periode::where('id', $id_periode)->where('status', 'aktif')->firstOrFail();

        $find_terpilih = DebiturTerpilih::where('id_periode', $find_periode->id)->get();

        if ($find_terpilih->count() <= 0) {
            throw new \Exception('Tidak Dapat Mempublish, Debitur Terpilih Masih Kosong');
        }

        foreach ($find_terpilih as $data) {
            $data->status = 'publish';
            $data->save();
        }

        $find_periode->status = 'nonaktif';
        $find_periode->save();

        return $find_terpilih;
    }
}
