<?php

namespace App\Http\Controllers\User;

use App\Exceptions\RegistrationFailException;
use App\Exceptions\UserRegistrationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use App\Services\User\UserAuthService;
use App\Traits\ResponseTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ResponseTraits;

    /**
     * @var UserAuthService $userAuthService
     */
    private UserAuthService $userAuthService;

    public function __construct(UserAuthService $userAuthService)
    {
        $this->userAuthService = $userAuthService;
    }

    public function register(UserRegisterRequest $request)
    {
        $token = $this->userAuthService->register($request->validated());
        return $this->success('Registration successful', [
            'token' => $token,
        ]);
    }
}
