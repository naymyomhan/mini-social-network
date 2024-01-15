<?php

namespace App\Services\User;

use App\Exceptions\CreateDataFailException;
use App\Exceptions\DeleteDataFailException;
use App\Exceptions\ResourceForbiddenException;
use App\Exceptions\UserAlreadyReactedException;
use App\Models\Post;
use App\Models\React;
use App\Traits\ResponseTraits;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class ReactService
{
    use ResponseTraits;

    /**
     * Add Reaction
     *
     * @param int $postId
     * @param string $reaction
     * @return React
     */
    public function addReact($postId, $reaction): React
    {
        //check if already have reaction
        $existingReact = React::where('user_id', Auth::guard('user')->id())
            ->where('post_id', $postId)
            ->first();

        if ($existingReact) {
            throw new UserAlreadyReactedException();
        }

        try {
            DB::beginTransaction();
            $post = Post::findOrFail($postId);

            $newReact = React::create([
                'user_id' => Auth::guard('user')->id(),
                'post_id' => $postId,
                'reaction' => $reaction,
            ]);

            $post->increment('react_count');

            DB::commit();

            return $newReact;
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            throw new ResourceNotFoundException('Post not found');
        } catch (\Exception $e) {
            DB::rollBack();
            throw new CreateDataFailException($e->getMessage(), 500);
        }
    }

    public function removeReact($reactId): bool
    {
        $react = React::find($reactId);
        if (!$react) {
            throw new ResourceNotFoundException('React not found');
        }

        if ($react->user_id !== Auth::guard('user')->id()) {
            throw new ResourceForbiddenException('Not allow to remove this reaction');
        }

        try {

            DB::beginTransaction();
            $post = Post::findOrFail($react->post_id);

            $react->delete();

            $post->decrement('react_count');

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new DeleteDataFailException($th->getMessage());
        }
    }
}
