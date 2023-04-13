<?php

namespace App\Http\Requests\Periode;

use Illuminate\Foundation\Http\FormRequest;

class PeriodeStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nama_periode' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:500',
            'tgl_awal_penilaian' => 'required|date',
            'tgl_akhir_penilaian' => 'required|date',
            'tgl_pengumuman' => 'required|date',
            'status' => 'nullable|in:aktif,nonaktif',
        ];
    }
}
