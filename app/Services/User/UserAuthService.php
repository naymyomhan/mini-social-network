<?php

namespace App\Services\User;

use App\Exceptions\RegistrationFailException;
use App\Exceptions\ResourceForbiddenException;
use App\Models\User;
use App\Notifications\WelcomeNotificaton;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class UserAuthService
{
    /**
     * User Register
     *
     * @param array $userData
     * @return string token
     */
    public function register(array $userData): string
    {
        DB::beginTransaction();
        try {
            $user = User::create($userData);
            $user->notify(new WelcomeNotificaton());
            $token = $user->createToken('user-token')->plainTextToken;
            DB::commit();
            return $token;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new RegistrationFailException($th->getMessage());
        }
    }

    /**
     * User Login
     *
     * @param array $loginData
     * @return string token
     */
    public function login(array $loginData): string
    {
        $user = User::where('email', $loginData['email'])->first();

        if (is_null($user)) {
            throw new ResourceNotFoundException('User not found');
        }

        if (!Hash::check($loginData['password'], $user->password)) {
            throw new ResourceForbiddenException('Incorrect password');
        }

        return $user->createToken('user-token')->plainTextToken;
    }
}
