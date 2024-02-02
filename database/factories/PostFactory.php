<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\React;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'topic_id' => fake()->numberBetween(1, 10),
            'title' => fake()->sentence(),
            'body' => fake()->paragraph(),
            'commentable' => fake()->boolean(),
            'pin' => fake()->boolean(0.1),
            'react_count' => fake()->numberBetween(0, 100),
            'comment_count' => fake()->numberBetween(0, 50),
            'share_count' => fake()->numberBetween(0, 20),
        ];
    }

    // public function withComments(int $count = 2)
    // {
    //     return $this->has(Comment::factory()->count($count));
    // }

    // public function withReacts(int $count = 5)
    // {
    //     return $this->hasMany(React::factory()->count($count));
    // }
}
