<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getLoginUser(int | null $id): User | null
    {
        return User::find($id);
    }
}