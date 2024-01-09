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
            'images' => $this->getImages(),
        ];
    }

    private function getImages(): array
    {
        $imageList = [];
        $mediaItems = $this->getMedia('post_images');

        foreach ($mediaItems as $item) {
            $imageList[] = $item->getUrl();
        }


        return $imageList;
    }
}
