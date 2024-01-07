<?php

namespace App\Services\User;

use App\Exceptions\UpdateProfileFailException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class ProfileService
{
    //Get My Profile
    public function getMyProfile(): User
    {
        $user = Auth::guard('user')->user();
        return $user;
    }

    //Update My Profile
    public function updateMyProfile($userData): User
    {
        /** @var \App\Models\User $user **/
        $user = Auth::guard('user')->user();

        $fillableProperties = $user->getFillable();

        foreach ($userData as $key => $value) {
            if (in_array($key, $fillableProperties) && $value !== null) {
                $user->$key = $value;
            }
        }

        // Handle profile picture upload
        if (isset($userData['profile_picture'])) {
            $file = $userData['profile_picture'];
            try {
                $filename = $this->generateUniqueFilename($file);
                Storage::disk('minio')->put($filename, file_get_contents($file));
                $user->profile_picture = $filename;
            } catch (\Exception $e) {
                throw new UpdateProfileFailException($e->getMessage());
            }
        }


        try {
            $user->save();
        } catch (\Exception $e) {
            throw new UpdateProfileFailException($e->getMessage());
        }

        return $user;
    }

    private function generateUniqueFilename($file): string
    {
        $extension = $file->extension();
        $filename = 'profile_pictures/' . uniqid() . '.' . $extension;

        while (Storage::disk('minio')->exists($filename)) {
            $filename = 'profile_pictures/' . uniqid() . '.' . $extension;
        }

        return $filename;
    }
}
