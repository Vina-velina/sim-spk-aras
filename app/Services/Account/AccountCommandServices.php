<?php

namespace App\Services\Account;

use App\Helpers\FileHelpers;
use App\Http\Requests\Account\AccountPasswordRequest;
use App\Http\Requests\Account\AccountUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AccountCommandServices
{
    function update(AccountUpdateRequest $request)
    {
        // dd($request->all());
        $user = Auth::user();
        // check if user upload new profile picture
        if ($request->hasFile('foto_profil')) {
            $filename = $filename = self::generateNameImage($request->file('foto_profil')->getClientOriginalExtension(), $user->id);
            $path = storage_path('app/public/images/foto-user');
            $file = FileHelpers::saveFile($request->file('foto_profil'), $path, $filename);
        }

        $request->validated();
        if ($request->hasFile('foto_profil')) {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'foto_profil' => $file,
            ];
        } else {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
            ];
        }

        $user = User::where('id', $user->id)->update($data);

        return $user;
    }

    function updatePassword(AccountPasswordRequest $request)
    {
        $user = Auth::user();
        $request->validated();
        $password = '';

        $password = bcrypt($request->password_baru);

        $user = User::where('id', $user->id)->update(['password' => $password]);

        return $user;
    }

    protected static function generateNameImage($extension, $unique)
    {
        $name = 'foto-user-' . $unique . '-' . time() . '.' . $extension;

        return $name;
    }
}
