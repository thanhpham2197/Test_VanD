<?php

namespace App\Repository;

use App\Models\User;
use App\Repository\Interface\UserRepositoryInterFace;

class UserRepository extends BaseRepository implements UserRepositoryInterFace
{
    public function getModel()
    {
        return User::class;
    }

    /**
     * Register user
     * 
     * @param array $user
     * 
     * @return \App\Models\User
     */
    public function register(array $user)
    {
        return $this->model->create($user);
    }
}
