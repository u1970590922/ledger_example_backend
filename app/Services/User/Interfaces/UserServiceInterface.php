<?php

namespace App\Services\User\Interfaces;

use App\Models\Auth\User;
use Illuminate\Support\Collection;

interface UserServiceInterface
{
    /**
     * 取得全部使用者
     *
     * @return Collection
     */
    public function getAllUsers(): Collection;

    /**
     * 傳入email並取得使用者
     *
     * @param  string  $email
     * @return User|null
     */
    public function getByEmail(string $email): User|null;

    /**
     * 新增使用者
     *
     * @param  array  $data
     * @return User
     */
    public function create(array $data): User;

    /**
     * 更新使用者
     *
     * @param  User  $model
     * @param  array  $data
     * @return User
     */
    public function update(User $model, array $data): User;

    /**
     * 刪除使用者(軟刪除)
     *
     * @param  User  $model
     * @return User
     */
    public function delete(User $model): User;
}
