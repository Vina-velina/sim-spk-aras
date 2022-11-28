<?php

namespace App\Services\User;

use App\Models\User;

class UserQueryServices
{

    public function findById(string $id)
    {
        return User::where('id', $id)->first();
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }
}
