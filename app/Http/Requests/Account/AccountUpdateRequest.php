<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class AccountUpdateRequest extends FormRequest
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
            'foto_profil' => 'nullable|mimes:jpeg,png,jpg|max:2048|image',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ];
    }
}
