<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Item;
use App\Models\Tag;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed independent entities first
        $this->call([
            TagSeeder::class,
            CategorySeeder::class,
            CitySeeder::class,
        ]);

        // Create test users
        User::firstOrCreate(['email' => 'test@example.com'], ['name' => 'Test User', 'password' => bcrypt('password'), 'email_verified_at' => now()]);
        User::firstOrCreate(['email' => 'admin@test.com'], ['name' => 'Admin User', 'password' => bcrypt('password'), 'email_verified_at' => now()]);
        User::firstOrCreate(['email' => 'jane@test.com'], ['name' => 'Jane Doe', 'password' => bcrypt('password'), 'email_verified_at' => now()]);

        // Create additional users for realistic demo data
        User::factory(15)->create();

        // Seed realistic items
        $this->call([
            ItemSeeder::class,
        ]);

        // Add some comments and votes to the realistic items
        $items = Item::all();
        $users = User::all();

        $items->each(function (Item $item) use ($users) {
            // Add random comments (0-5 per item)
            Comment::factory(mt_rand(0, 5))->create([
                'item_id' => $item->id,
                'user_id' => $users->random()->id,
            ]);

            // Add random votes (3-15 per item)
            $voters = $users->random(mt_rand(3, 15));
            foreach ($voters as $voter) {
                if ($voter->id !== $item->user_id && ! $item->votes()->where('user_id', $voter->id)->exists()) {
                    Vote::factory()->create([
                        'item_id' => $item->id,
                        'user_id' => $voter->id,
                    ]);
                }
            }
        });
    }
}
