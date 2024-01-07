<?php

namespace App\Services\User;

use App\Exceptions\PostUploadFailException;
use App\Helpers\FileHelper;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
