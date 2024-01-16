<?php

namespace App\Services\User;

use App\Exceptions\CreateDataFailException;
use App\Exceptions\DeleteDataFailException;
use App\Exceptions\ResourceForbiddenException;
use App\Models\Comment;
use App\Models\Post;
use App\Traits\ResponseTraits;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class CommentService
{
    use ResponseTraits;

    /**
     * Add Comment
     *
     * @param int $postId
     * @param string $comment
     * @return Comment
     */
    public function addComment($postId, $comment)
    {
        try {
            DB::beginTransaction();
            $post = Post::findOrFail($postId);

            $comment = Comment::create([
                'user_id' => Auth::guard('user')->id(),
                'post_id' => $postId,
                'comment' => $comment,
            ]);

            $post->increment('comment_count');

            DB::commit();

            return $comment;
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            throw new ResourceNotFoundException('Post not found');
        } catch (\Exception $e) {
            DB::rollBack();
            throw new CreateDataFailException($e->getMessage(), 500);
        }
    }

    public function removeComment($commentId)
    {
        $comment = Comment::find($commentId);
        if (!$comment) {
            throw new ResourceNotFoundException('Comment not found');
        }

        if ($comment->user_id !== Auth::guard('user')->id()) {
            throw new ResourceForbiddenException('Not allow to remove this comment');
        }

        try {

            DB::beginTransaction();
            $post = Post::findOrFail($comment->post_id);

            $comment->delete();

            $post->decrement('comment_count');

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new DeleteDataFailException($th->getMessage());
        }
    }
}
