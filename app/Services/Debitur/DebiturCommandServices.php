<?php

namespace App\Services\Debitur;

use App\Helpers\FileHelpers;
use App\Http\Requests\Debitur\DebiturStoreRequest;
use App\Http\Requests\Debitur\DebiturUpdateRequest;
use App\Models\Debitur;

class DebiturCommandServices
{
    public function updateStatus(string $id)
    {
        $query = Debitur::find($id);
        $query->status = $query->status == 'aktif' ? 'nonaktif' : 'aktif';
        $query->save();

        return $query;
    }

    public function store(DebiturStoreRequest $request)
    {
        $request->validated();
        $filenamesave = null;
        if ($request->hasFile('foto_debitur')) {
            $filename = self::generateNameImage($request->file('foto_debitur')->getClientOriginalExtension(), $request->nomor_ktp);
            $path = storage_path('app/public/foto-debitur');
            $filenamesave = FileHelpers::saveFile($request->file('foto_debitur'), $path, $filename);
        }
        $query = new Debitur();
        $query->nama = ucwords(strtolower($request->nama_debitur));
        $query->alamat = $request->alamat_debitur;
        $query->foto = $filenamesave;
        $query->pekerjaan = $request->pekerjaan_debitur;
        $query->no_telp = $request->nomor_telepon;
        $query->no_ktp = $request->nomor_ktp;
        $query->status = $request->status;
        $query->save();

        return $query;
    }

    public function update(DebiturUpdateRequest $request, string $id)
    {
        $request->validated();
        $query = Debitur::find($id);
        $filenamesave = null;
        if ($request->hasFile('foto_debitur')) {
            $path = storage_path('app/public/foto-debitur');
            if (isset($query->foto)) {
                $pathOld = $path.'/'.$query->foto;
                FileHelpers::removeFile($pathOld);
            }
            $filename = $query->foto;
            $filenamesave = FileHelpers::saveFile($request->file('foto_debitur'), $path, $filename);
        }
        $query->nama = ucwords(strtolower($request->nama_debitur));
        $query->alamat = $request->alamat_debitur;
        $query->foto = $filenamesave;
        $query->pekerjaan = $request->pekerjaan_debitur;
        $query->no_telp = $request->nomor_telepon;
        $query->no_ktp = $request->nomor_ktp;
        $query->status = $request->status;
        $query->save();

        return $query;
    }

    public function delete(string $id)
    {
        $find = Debitur::find($id);
        if (isset($find->foto)) {
            // $path = storage_path('app/public/foto-debitur');
            // $pathOld = $path . '/' . $find->foto;
            $path = storage_path('app/public/foto-debitur/'.$find->foto);
            FileHelpers::deleteFile($path);
            // FileHelpers::removeFile($pathOld);
        }

        return $find->delete();
    }

    protected static function generateNameImage($extension, $unique)
    {
        $name = 'foto-debitur'.$unique.'-'.time().'.'.$extension;

        return $name;
    }
}
