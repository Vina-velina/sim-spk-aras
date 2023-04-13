<?php

namespace App\Http\Requests\Debitur;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DebiturStoreRequest extends FormRequest
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
            'nama_debitur' => 'required|string|max:255',
            'alamat_debitur' => 'required|string|max:500',
            'pekerjaan_debitur' => 'nullable|string|max:255',
            'nomor_telepon' => ['nullable', 'unique:debiturs,no_telp', 'numeric', 'digits_between:10,13', Rule::phone()->detect()->country('ID')],
            'nomor_ktp' => 'nullable|numeric|unique:debiturs,no_ktp|digits_between:10,16',
            'status' => 'nullable|in:aktif,nonaktif',
            'foto_debitur' => 'nullable|mimes:jpeg,png,jpg|max:2048|image',
        ];
    }
}
