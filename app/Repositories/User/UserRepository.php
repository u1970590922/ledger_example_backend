<?php

namespace App\Repositories\User;

use App\Repositories\Repository;
use App\Models\Auth\User;
use Illuminate\Support\Collection;

class UserRepository extends Repository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * 查詢全部使用者
     *
     * @return Collection
     */
    public function getAllUsers(): Collection
    {
        return $this->model->get();
    }

    /**
     * 查詢email並取得第一個使用者
     *
     * @param  string  $email
     * @return User|null
     */
    public function getByEmail(string $email): User|null
    {
        return $this->model->where('email', $email)->first();
    }
}