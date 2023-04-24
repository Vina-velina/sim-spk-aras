<?php

namespace App\Services\Account;

use App\Helpers\FileHelpers;
use App\Http\Requests\Account\AccountPasswordRequest;
use App\Http\Requests\Account\AccountUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountCommandServices
{
    public function update(AccountUpdateRequest $request)
    {
        $request->validated();

        $user = Auth::user();

        if ($request->hasFile('foto_profil')) {
            $path = 'app/public/foto-user';
            if (isset($user->foto_profil)) {
                $file = storage_path($path . '/' . $user->foto_profil);
                FileHelpers::deleteFile($file);
            }

            $filename = self::generateNameImage($request->file('foto_profil')->getClientOriginalExtension(), uniqid());

            $create_in = storage_path($path);
            $create_file = FileHelpers::saveFile($request->file('foto_profil'), $create_in, $filename);
        } else {
            $create_file = $user->foto_profil;
        }

        $query = User::where('id', $user->id)->first();
        $query->name = $request->name;
        $query->email = $request->email;
        $query->foto_profil = $create_file;
        $query->save();
        return $user;
    }

    public function updatePassword(AccountPasswordRequest $request)
    {
        $user = Auth::user();
        $request->validated();

        $password = Hash::make($request->password_baru);

        $query = User::where('id', $user->id)->first();
        $query->password = $password;
        $query->save();

        return $query;
    }

    protected static function generateNameImage($extension, $unique)
    {
        $name = 'foto-user' . $unique . '-' . time() . '.' . $extension;

        return $name;
    }
}
