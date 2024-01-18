<?php

namespace App\Services\User;

use App\Exceptions\CreateDataFailException;
use App\Exceptions\TopicAlreadySubscribeException;
use App\Models\Subscribe;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TopicService
{
    /**
     * @return Collection|Topic[]
     */
    public function getTopics(): Collection
    {
        $user = Auth::guard('user')->user();
        $topics = Topic::all(['id', 'topic', 'icon', 'subscriber_count']);

        $userSubscriptions = $user ? $user->subscriptions->pluck('topic_id')->toArray() : [];

        foreach ($topics as $topic) {
            $topic->subscribed = in_array($topic->id, $userSubscriptions);
        }

        return $topics;
    }

    public function getSubscribedTopics(): Collection
    {
        $user = Auth::guard('user')->user();
        $subscriptions = $user->subscriptions;

        return $subscriptions;
    }

    /**
     * Subscribe to topic
     *
     * @param int $topicId
     * @return Subscribe
     */
    public function subscribeTopic($topicId): Subscribe
    {
        $userId = Auth::guard('user')->id();

        $isSubscribed = Subscribe::where('user_id', $userId)
            ->where('topic_id', $topicId)
            ->exists();

        if ($isSubscribed) {
            throw new TopicAlreadySubscribeException();
        }

        $topic = Topic::findOrFail($topicId);

        try {

            DB::beginTransaction();

            $subscribe = Subscribe::create([
                'user_id' => $userId,
                'topic_id' => $topicId,
            ]);

            $topic->increment('subscriber_count');

            DB::commit();

            return $subscribe;
        } catch (\Exception $e) {
            DB::rollback();
            throw new CreateDataFailException($e->getMessage());
        }
    }
}
