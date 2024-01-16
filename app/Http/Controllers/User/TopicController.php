<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use App\Models\Topic;
use App\Services\User\TopicService;
use App\Traits\ResponseTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    use ResponseTraits;

    /**
     * @var TopicService $topicService;
     */
    protected TopicService $topicService;

    public function __construct(TopicService $topicService)
    {
        $this->topicService = $topicService;
    }

    public function getTopics()
    {
        $topics = $this->topicService->getTopics();
        return $this->success('Get topics successful', $topics);
    }

    public function subscribeTopic($id)
    {
        $subscribe = $this->topicService->subscribeTopic($id);
        return $this->success('Subscribe topic successful', $subscribe);
    }
}
