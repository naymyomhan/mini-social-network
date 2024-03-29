<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'profile_picture' => $this->profile_picture,
            'dob' => $this->dob,
            'gender' => $this->gender,
            'bio' => $this->bio,
            'location' => $this->location,
            'followers_count' => $this->followers_count,
            'following_count' => $this->following_count,
        ];
    }
}
