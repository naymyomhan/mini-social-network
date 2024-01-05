<?php

namespace App\Http\Controllers\User;

use App\Exceptions\UserRegistrationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use App\Services\User\UserAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private UserAuthService $userAuthService;

    public function __construct(UserAuthService $userAuthService)
    {
        $this->userAuthService = $userAuthService;
    }

    public function register(UserRegisterRequest $request)
    {
        try {
            $user = $this->userAuthService->register($request->validated());

            $data = [
                "user" => $user,
                "token" => $user->token,
            ];
            return response()->success($data, 'User register successfully', 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
