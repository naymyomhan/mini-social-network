<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PostResource extends JsonResource
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
            'body' => $this->body,
            'commentable' => $this->commentable,
            'react_count' => $this->react_count,
            'comment_count' => $this->comment_count,
            'share_count' => $this->share_count,
            'user' => new UserResource($this->user),
            'topic' => new TopicResource($this->topic),
            'images' => $this->getImages($this->images),
        ];
    }

    private function getImages($imagesString): array
    {
        $imagesArray = explode(',', $imagesString);
        $images = [];
        foreach ($imagesArray as $image) {
            $images[] = Storage::disk('minio')->temporaryUrl($image, now()->addMinutes(5));
        }

        return $images;
    }
}
