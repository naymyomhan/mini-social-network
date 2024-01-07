<?php

namespace App\Services\User;

use App\Http\Resources\UserDetailResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class UserService
{
    public function getUsers(): LengthAwarePaginator
    {
        $query = User::query();

        //TODO::Search and filters

        $users = $query->paginate(5);

        return $users;
    }

    //Get User Profile
    public function getUserProfile($id, $selfId): User
    {
        if ($id === $selfId) {
            throw new ResourceNotFoundException('User not found');
        }

        $user = User::find($id);

        if (is_null($user)) {
            throw new ResourceNotFoundException('User not found');
        }

        return $user;
    }
}
