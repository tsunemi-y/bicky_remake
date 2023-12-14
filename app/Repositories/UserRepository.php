<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getLoginUser(int $id): User
    {
        return User::find($id);
    }
}