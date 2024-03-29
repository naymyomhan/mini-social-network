<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\MyProfileResource;
use App\Services\User\ProfileService;
use App\Traits\ResponseTraits;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use ResponseTraits;

    /**
     * @var ProfileService $profileService
     */
    private ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * Get the authenticated user's profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMyProfile()
    {
        $user = $this->profileService->getMyProfile();
        return $this->success('Get profile successful', new MyProfileResource($user));
    }

    /**
     * Update the authenticated user's profile.
     *
     * @param UpdateProfileRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMyProfile(UpdateProfileRequest $request)
    {
        $user = $this->profileService->updateMyProfile($request->validated());
        return $this->success('Update profile successful', new MyProfileResource($user));
    }
}
