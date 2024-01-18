<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topics = [
            ['topic' => 'Technology'],
            ['topic' => 'Music'],
            ['topic' => 'Movie'],
            ['topic' => 'Digital Art'],
            ['topic' => 'Photography'],
            ['topic' => 'Videography'],
            ['topic' => 'Programming'],
            ['topic' => 'Audio Design'],
            ['topic' => 'Health'],
            ['topic' => 'Relatinoship'],
            ['topic' => 'Education'],
        ];

        DB::table('topics')->insert($topics);
    }
}
