<?php

namespace App\Http\Controllers\User;

use App\Exceptions\RegistrationFailException;
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
            DB::beginTransaction();
            $user = $this->userAuthService->register($request->validated());
            $token = $user->createToken("user-token")->plainTextToken;

            $data = [
                "user" => $user,
                "token" => $token,
            ];
            DB::commit();
            return response()->success($data, 'User register successfully', 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw RegistrationFailException::registrationFail($th->getMessage());
        }
    }
}
