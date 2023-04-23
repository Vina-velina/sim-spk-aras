<?php

namespace App\Http\Requests\Penilaian;

use App\Models\KriteriaPenilaian;
use Illuminate\Foundation\Http\FormRequest;

class PenilaianStoreUpdateRequest extends FormRequest
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
            // Menyertakan rules untuk setiap input yang ada dalam form
            'penilaian.*' => 'required|numeric', // Menggunakan wildcard untuk mengakses setiap input penilaian
        ];
    }

    public function messages()
    {
        // Menyertakan custom messages untuk pesan error
        $messages = [];
        foreach (request()->penilaian as $kriteriaId => $nilai) {
            $kriteria = KriteriaPenilaian::find($kriteriaId);
            $messages["penilaian.{$kriteriaId}.required"] = 'Kolom Nilai Pada Kriteria "' . $kriteria->masterKriteriaPenilaian->nama_kriteria . '" Harus Diisi.';
            $messages["penilaian.{$kriteriaId}.numeric"] = 'Kolom Nilai Pada Kriteria "' . $kriteria->masterKriteriaPenilaian->nama_kriteria . '" Harus Berupa Angka.';
        }
        return $messages;
    }

    public function attributes()
    {
        // Menyertakan custom attribute untuk menggantikan :attribute dalam pesan error
        $attributes = [];
        foreach (request()->penilaian as $kriteriaId => $nilai) {
            $kriteria = KriteriaPenilaian::find($kriteriaId);
            $attributes["penilaian.{$kriteriaId}"] = $kriteria ? $kriteria->nama_kriteria : 'Kriteria';
        }
        return $attributes;
    }
}
