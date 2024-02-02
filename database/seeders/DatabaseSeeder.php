<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Comment;
use App\Models\Post;
use App\Models\React;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TopicsTableSeeder::class);

        User::factory()
            ->has(Post::factory()->count(18))
            ->count(2024)
            ->create();

        // Comment::factory()->count(10)->create();

        // React::factory()->count(10)->create();
    }
}
