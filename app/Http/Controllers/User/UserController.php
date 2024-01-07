<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserDetailResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\User\UserService;
use App\Traits\ResponseTraits;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ResponseTraits;

    /**
     * @var UserService $userService
     */
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    //Get User List
    public function getUsers()
    {
        $users = $this->userService->getUsers();
        return $this->success('Get users successful', UserResource::collection($users));
    }

    //Get User Profile
    public function getUserProfile($id)
    {
        $user = $this->userService->getUserProfile($id, request()->user()->id);
        return $this->success('Get user detail successful', new UserDetailResource($user));
    }
}
