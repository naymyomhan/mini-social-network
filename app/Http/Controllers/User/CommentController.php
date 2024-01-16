<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Services\User\CommentService;
use App\Traits\ResponseTraits;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use ResponseTraits;
    /**
     * @var CommentService $commentService;
     */
    protected CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function addComment(CommentRequest $request, $id)
    {
        $comment = $this->commentService->addComment($id, $request->comment);
        return $this->success('Add comment successful', $comment);
    }

    public function removeComment($id)
    {
        $this->commentService->removeComment($id);
        return $this->success('Remove comment successful');
    }
}
