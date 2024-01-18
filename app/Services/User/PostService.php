<?php

namespace App\Services\User;

use App\Exceptions\CreateDataFailException;
use App\Exceptions\PostUploadFailException;
use App\Exceptions\UserAlreadyReactedException;
use App\Helpers\FileHelper;
use App\Models\Post;
use App\Models\React;
use App\Traits\ResponseTraits;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class PostService
{
    use ResponseTraits;

    public function getPosts(): LengthAwarePaginator
    {
        $query = Post::query();

        //TODO::Search and filters

        $posts = $query->paginate(20);

        return $posts;
    }

    public function getPostDetail($id): Post
    {
        $post = Post::findOrFail($id);
        return $post;
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
                        ->toMediaCollection('post_images');
                }
            }

            return $newPost;
        } catch (\Throwable $th) {
            throw new PostUploadFailException($th->getMessage());
        }
    }
}
