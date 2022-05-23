<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseApiController;
use App\Services\Auth\Interfaces\GuardServiceInterface;
use Illuminate\Http\Request;

class GuardController extends BaseApiController
{
    protected GuardServiceInterface $guardService;

    public function __construct(GuardServiceInterface $guardService)
    {
        $this->guardService = $guardService;
    }

    public function login(Request $request)
    {
        $validated = $this->validateLogin($request);

        $result = $this->guardService->login($validated);

        //todo
        return;
    }

    private function validateLogin(Request $request): array
    {
        return $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255'
        ]);
    }
}
