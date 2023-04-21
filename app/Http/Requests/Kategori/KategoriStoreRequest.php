<?php

namespace App\Http\Requests\Kategori;

use Illuminate\Foundation\Http\FormRequest;

class KategoriStoreRequest extends FormRequest
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
            'nama_kriteria' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'bobot_kriteria' => 'required|integer|between:1,100',
            'status' => 'required|in:aktif,nonaktif|string',
        ];
    }
}
