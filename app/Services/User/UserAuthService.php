<?php

namespace App\Services\User;

use App\Exceptions\RegistrationFailException;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserAuthService
{
    public function register(array $userData): User
    {
        try {
            $user = User::create($userData);
            $token = $user->createToken("user-token")->plainTextToken;
            return $user->fresh('token');
        } catch (\Throwable $th) {
            Log::error("User registration failed: {$th->getMessage()}");
            throw RegistrationFailException::registrationFail($th->getMessage());
        }
    }
}
