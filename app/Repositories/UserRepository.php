<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\User;

class UserRepository extends Repository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}          