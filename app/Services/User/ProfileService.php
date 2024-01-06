<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileService
{
    public function getMyProfile(): User
    {
        $user = Auth::guard('user')->user();
        return $user;
    }


    public function updateMyProfile($userData): User
    {
        /** @var \App\Models\User $user **/
        $user = Auth::guard('user')->user();

        foreach ($userData as $key => $value) {
            if ($value !== null) {
                $user->$key = $value;
            }
        }

        $user->save();

        return $user;
    }
}
