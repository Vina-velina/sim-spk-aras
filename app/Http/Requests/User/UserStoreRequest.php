<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'foto_user' => 'nullable|mimes:jpeg,png,jpg|max:2048|image',
            'nama_user' => 'required|string|max:255',
            'email_user' => 'required|string|email|max:255|unique:users,email',
            'role' => 'required|in:super_admin,admin|string',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
