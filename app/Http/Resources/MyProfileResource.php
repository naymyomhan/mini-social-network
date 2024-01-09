<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MyProfileResource extends JsonResource
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
            'email' => $this->email,
            'avatar' => $this->getFirstMediaUrl('avatar'),
            'avatar_thumbnail' => $this->getMedia('avatar')[0]->getUrl('thumb'),
            'dob' => $this->dob,
            'gender' => $this->gender,
            'bio' => $this->bio,
            'location' => $this->location,
            'followers_count' => $this->followers_count,
            'following_count' => $this->following_count,
        ];
    }
}
