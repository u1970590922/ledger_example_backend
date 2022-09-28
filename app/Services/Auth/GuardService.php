<?php

namespace App\Services\Auth;

use App\Models\Auth\User;
use App\Services\User\Interfaces\UserServiceInterface;
use App\Services\Auth\Interfaces\GuardServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\StatefulGuard;

class GuardService implements GuardServiceInterface
{
    /**
     * 登出成功訊息
     * 
     * @var string
     */
    public const LOGOUT_SUCCESS = '登出成功';

    /**
     * 登入成功訊息
     * 
     * @var string
     */
    protected const LOGIN_SUCCESS = '登入成功';

    /**
     * 登入失敗訊息
     * 
     * @var string
     */
    protected const LOGIN_FAIL = '登入失敗';

    /**
     * UserService
     *
     * @var UserServiceInterface
     */
    protected UserServiceInterface $userService;

    /**
     * 建構子
     *
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * 將用戶登入至系統
     *
     * @param  array  $credentials [
     *     'email' => string,
     *     'password' => string,
     * ]
     * 
     * @return array
     */
    public function login(array $credentials): array
    {
        if ($status = $this->guard()->attempt($credentials)) {
            $this->authenticated($this->guard()->user());
            $message = self::LOGIN_SUCCESS;
        } else {
            $message = self::LOGIN_FAIL;
        }

        return ['status' => $status, 'message' => $message];
    }

    /**
     * 將用戶登出系統
     *
     * @return void
     */
    public function logout(): void
    {
        $this->guard()->logout();
    }

    /**
     * 用戶已通過身份驗證
     *
     * @param User $user
     * @return void
     */
    protected function authenticated(User $user): void
    {
        //
    }

    /**
     * 取得給定的守衛
     *
     * @param  string|null  $guard
     * @return StatefulGuard
     */
    protected function guard(?string $guard = null)
    {
        return Auth::guard($guard);
    }
}
