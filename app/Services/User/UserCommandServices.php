<?php

namespace App\Services\User;

use App\Helpers\FileHelpers;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserCommandServices
{
    public function store(UserStoreRequest $request)
    {
        $request->validated();
        // check if user upload new profile picture
        if ($request->hasFile('foto_profil')) {
            $filename = self::generateNameImage($request->file('foto_profil')->getClientOriginalExtension(), uniqid());
            $path = storage_path('app/public/foto-user');
            $file = FileHelpers::saveFile($request->file('foto_profil'), $path, $filename);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'foto_profil' => $file,
                'password' => bcrypt($request->password),
                'role_user' => $request->role_user,
            ]);

            return $user;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_user' => $request->role_user,
        ]);

        return $user;
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);

        if ($request->hasFile('foto_profil')) {
            $path = 'app/public/foto-user';
            if (isset($user->foto_profil)) {
                $file = storage_path($path.'/'.$user->foto_profil);
                FileHelpers::deleteFile($file);
            }

            $filename = self::generateNameImage($request->file('foto_profil')->getClientOriginalExtension(), uniqid());

            $create_in = storage_path($path);
            $create_file = FileHelpers::saveFile($request->file('foto_profil'), $create_in, $filename);
        } else {
            $create_file = $user->foto_profil;
        }

        $user = User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'foto_profil' => $create_file,
            'password' => Hash::make($request->password),
            'role_user' => $request->role_user,
        ]);

        return $user;
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $path = storage_path('app/public/foto-user/'.$user->foto_profil);
        FileHelpers::deleteFile($path);
        $user->delete();

        return $user;
    }

    protected static function generateNameImage($extension, $unique)
    {
        $name = 'foto-user-'.$unique.'-'.time().'.'.$extension;

        return $name;
    }
}
