<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Item;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(['email' => 'test@example.com'], ['name' => 'Test User', 'password' => bcrypt('password'), 'email_verified_at' => now()]);
        User::firstOrCreate(['email' => 'admin@test.com'], ['name' => 'Admin User', 'password' => bcrypt('password'), 'email_verified_at' => now()]);
        User::firstOrCreate(['email' => 'jane@test.com'], ['name' => 'Jane Doe', 'password' => bcrypt('password'), 'email_verified_at' => now()]);

        User::factory(10)
            ->has(
                Item::factory()->count(mt_rand(5, 10))
                    ->has(
                        Comment::factory()->count(mt_rand(0, 5)),
                        'comments'
                    )
                    ->has(
                        Vote::factory()->count(mt_rand(5, 20)),
                        'votes'
                    )
            )
            ->create();

        $testUser = User::where('email', 'test@example.com')->first();
        if ($testUser) {
            Item::factory(50)
                ->has(Comment::factory()->count(mt_rand(1, 3)), 'comments')
                ->has(Vote::factory()->count(mt_rand(5, 15)), 'votes')
                ->create([
                    'user_id' => $testUser->id,
                ]);
        }
    }
}
