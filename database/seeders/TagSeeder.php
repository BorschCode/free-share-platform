<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'Free', 'color' => '#10b981'],
            ['name' => 'Urgent', 'color' => '#ef4444'],
            ['name' => 'New', 'color' => '#3b82f6'],
            ['name' => 'Like New', 'color' => '#8b5cf6'],
            ['name' => 'Vintage', 'color' => '#f59e0b'],
            ['name' => 'Handmade', 'color' => '#ec4899'],
            ['name' => 'Collectible', 'color' => '#6366f1'],
            ['name' => 'Eco-Friendly', 'color' => '#059669'],
            ['name' => 'Rare', 'color' => '#dc2626'],
            ['name' => 'Bundle', 'color' => '#7c3aed'],
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['name' => $tag['name']], $tag);
        }
    }
}
