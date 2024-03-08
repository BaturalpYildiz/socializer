<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Post;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // turn off memory limit
        // ini_set('memory_limit', '-1');


        // create 150,000 posts
        // Post::factory()
        //     ->count(500)
        //     ->make()
        //     ->map(
        //         function ($post) {
        //             return [
        //                 'title' => $post->title,
        //                 'content' => $post->content,
        //                 'user_id' => $post->user_id,
        //                 'created_at' => $post->created_at->format('Y-m-d H:i:s'),
        //                 'status_id' => 2,
        //             ];
        //         }
        //     )
        //     ->chunk(10000)
        //     ->each(
        //         function ($chunk) {

        //             // dd($chunk->toArray());
        //             Post::insert($chunk->toArray());
        //         }
        //     );
    }
}
