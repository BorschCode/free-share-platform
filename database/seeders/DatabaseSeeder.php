<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'jane@test.com'],
            [
                'name' => 'Jane Doe',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        User::factory(10)
            ->has(
                Item::factory()->count(mt_rand(5, 10))
            )
            ->create();

        $testUser = User::where('email', 'test@example.com')->first();
        if ($testUser) {
            Item::factory(50)->create([
                'user_id' => $testUser->id,
            ]);
        }
    }
}
