<?php

namespace App\Services\User;

use App\Helpers\FileHelpers;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;

class UserCommandServices
{
    protected $property1;

    public function __construct($property1 = null)
    {
        $this->property1 = $property1;
    }

    public function getProperty1()
    {
        return $this->property1;
    }

    public function setProperty1($property1)
    {
        $this->property1 = $property1;
    }

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
        $request->validated();

        // check if user upload new profile picture
        if ($request->hasFile('foto_profil')) {
            // check if extension file is right
            $filename = $user->foto_profil;
            $path = storage_path('app/public/foto-user');
            $file = FileHelpers::saveFile($request->file('foto_profil'), $path, $filename);

            $user = User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'foto_profil' => $file,
                'password' => bcrypt($request->password),
                'role_user' => $request->role_user,
            ]);
        }

        $user = User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_user' => $request->role_user,
        ]);

        return $user;
    }

    protected static function generateNameImage($extension, $unique)
    {
        $name = 'foto-user-' . $unique . '-' . time() . '.' . $extension;

        return $name;
    }
}
