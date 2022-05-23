<?php

namespace App\Services\User;

use App\Models\Auth\User;
use App\Repositories\User\UserRepository;
use App\Services\User\Interfaces\UserServiceInterface;
use Illuminate\Support\Collection;

class UserService implements UserServiceInterface
{
    /**
     * UserRepository
     *
     * @var UserRepository
     */
    protected UserRepository $userRepo;

    /**
     * UserService 建構子
     *
     * @param UserRepository $userRepo
     */
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * 取得全部使用者
     *
     * @return Collection
     */
    public function getAllUsers(): Collection
    {
        return $this->userRepo->getAllUsers();
    }

    /**
     * 傳入email並取得使用者
     *
     * @param  string  $email
     * @return User|null
     */
    public function getByEmail(string $email): User|null
    {
        return $this->userRepo->getByEmail($email);
    }

    /**
     * 新增使用者
     *
     * @param  array  $data
     * @return User
     */
    public function create(array $data): User
    {
        return $this->userRepo->create($data);
    }

    /**
     * 更新使用者
     *
     * @param  User  $model
     * @param  array  $data
     * @return User
     */
    public function update(User $model, array $data): User
    {
        return $this->userRepo->update($model, $data);
    }

    /**
     * 刪除使用者(軟刪除)
     *
     * @param  User  $model
     * @return User
     */
    public function delete(User $model): User
    {
        return $this->userRepo->delete($model);
    }
}
