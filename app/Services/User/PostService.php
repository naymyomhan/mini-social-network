<?php

namespace App\Services\User;

use App\Exceptions\PostUploadFailException;
use App\Helpers\FileHelper;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostService
{
    /**
     * Upload Post
     *
     * @param array $postData
     * @return Post
     */
    public function uploadPost($postData)
    {
        try {
            if (isset($postData['images'])) {
                $images = [];
                $files = $postData['images'];
                foreach ($files as $file) {
                    $images[] = FileHelper::uploadFile($file, 'post');
                }
                $postData['images'] = implode(',', $images);
            }

            $postData['user_id'] = Auth::id();
            $newPost = Post::create($postData);
            return $newPost;
        } catch (\Throwable $th) {
            throw new PostUploadFailException($th->getMessage());
        }
    }
}
