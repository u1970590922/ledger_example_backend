<?php

namespace App\Services\Auth\Interfaces;

interface GuardServiceInterface
{
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
    public function login(array $credentials): array;

    /**
     * 將用戶登出系統
     *
     * @return void
     */
    public function logout(): void;
}