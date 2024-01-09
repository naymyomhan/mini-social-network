<?php

namespace App\Services\User;

use App\Exceptions\PostUploadFailException;
use App\Helpers\FileHelper;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PostService
{

    public function getPosts(): LengthAwarePaginator
    {
        $query = Post::query();

        //TODO::Search and filters

        $posts = $query->paginate(5);

        return $posts;
    }

    /**
     * Upload Post
     *
     * @param array $postData
     * @return Post
     */
    public function uploadPost($postData)
    {
        try {

            $postData['user_id'] = Auth::id();
            $newPost = Post::create($postData);

            if (isset($postData['images'])) {
                $images = $postData['images'];
                foreach ($images as $images) {
                    $filename = FileHelper::generateUniqueFilename($images);
                    $newPost->addMedia($images)
                        ->usingFileName($filename)
                        ->toMediaCollection('post_images', 'minio');
                }
            }

            return $newPost;
        } catch (\Throwable $th) {
            throw new PostUploadFailException($th->getMessage());
        }
    }
}
