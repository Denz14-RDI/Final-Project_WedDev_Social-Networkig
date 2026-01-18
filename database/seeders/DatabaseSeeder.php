<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Friend;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 5 test users
        $users = User::factory(5)->create();

        // Add some additional test users manually
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'username' => 'admin_user',
            'email' => 'admin@pupcom.local',
            'password' => bcrypt('password'),
            'bio' => 'I am an administrator of PUPCOM',
            'profile_pic' => null,
        ]);

        $john = User::create([
            'first_name' => 'John',
            'last_name' => 'Dela Cruz',
            'username' => 'johndc',
            'email' => 'john@pupcom.local',
            'password' => bcrypt('password'),
            'bio' => 'Computer Science student at PUP',
            'profile_pic' => null,
        ]);

        // Create 10 posts
        $posts = Post::factory(10)->create();

        // Create comments on posts
        foreach ($posts as $post) {
            Comment::factory(rand(1, 5))->create([
                'post_id' => $post->post_id,
            ]);
        }

        // Create likes on posts
        foreach ($posts as $post) {
            $likeCount = rand(0, 3);
            for ($i = 0; $i < $likeCount; $i++) {
                $user = $users->random();
                Like::firstOrCreate([
                    'post_id' => $post->post_id,
                    'user_id' => $user->user_id,
                ]);
            }
        }

        // Create friendships
        for ($i = 0; $i < count($users) - 1; $i++) {
            for ($j = $i + 1; $j < count($users); $j++) {
                if (rand(0, 1)) {
                    Friend::create([
                        'user_id_1' => $users[$i]->user_id,
                        'user_id_2' => $users[$j]->user_id,
                        'status' => rand(0, 1) ? 'accepted' : 'pending',
                    ]);
                }
            }
        }
    }
}
