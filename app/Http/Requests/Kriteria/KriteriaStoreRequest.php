<?php

namespace App\Http\Requests\Kriteria;

use Illuminate\Foundation\Http\FormRequest;

class KriteriaStoreRequest extends FormRequest
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
            'id_periode' => 'required|exists:periodes,id|string',
            'id_master_kriteria' => 'required|exists:master_kriteria_penilaians,id|string',
            'keterangan' => 'nullable|string|max:255',
            'bobot_kriteria' => 'required|integer|between:1,100',
            'jenis_kriteria' => 'required|in:benefit,cost|string',
            'status' => 'required|in:aktif,nonaktif|string',
        ];
    }
}
