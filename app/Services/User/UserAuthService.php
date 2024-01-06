<?php

namespace App\Services\User;

use App\Exceptions\RegistrationFailException;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserAuthService
{
    public function register(array $userData): string
    {
        DB::beginTransaction();
        try {
            $user = User::create($userData);
            $token = $user->createToken('User-Token')->plainTextToken;
            DB::commit();
            return $token;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new RegistrationFailException($th->getMessage());
        }
    }
}
