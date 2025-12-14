<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Electronic devices and gadgets',
                'children' => [
                    ['name' => 'Computers & Laptops', 'slug' => 'computers-laptops'],
                    ['name' => 'Phones & Tablets', 'slug' => 'phones-tablets'],
                    ['name' => 'Audio & Video', 'slug' => 'audio-video'],
                    ['name' => 'Gaming', 'slug' => 'gaming'],
                ],
            ],
            [
                'name' => 'Furniture',
                'slug' => 'furniture',
                'description' => 'Home and office furniture',
                'children' => [
                    ['name' => 'Living Room', 'slug' => 'living-room'],
                    ['name' => 'Bedroom', 'slug' => 'bedroom'],
                    ['name' => 'Office', 'slug' => 'office'],
                    ['name' => 'Outdoor', 'slug' => 'outdoor'],
                ],
            ],
            [
                'name' => 'Clothing',
                'slug' => 'clothing',
                'description' => 'Apparel and accessories',
                'children' => [
                    ['name' => 'Men', 'slug' => 'men'],
                    ['name' => 'Women', 'slug' => 'women'],
                    ['name' => 'Kids', 'slug' => 'kids'],
                    ['name' => 'Shoes', 'slug' => 'shoes'],
                ],
            ],
            [
                'name' => 'Books & Media',
                'slug' => 'books-media',
                'description' => 'Books, magazines, and media',
                'children' => [
                    ['name' => 'Books', 'slug' => 'books'],
                    ['name' => 'Magazines', 'slug' => 'magazines'],
                    ['name' => 'CDs & DVDs', 'slug' => 'cds-dvds'],
                ],
            ],
            [
                'name' => 'Home & Garden',
                'slug' => 'home-garden',
                'description' => 'Home decor and garden items',
                'children' => [
                    ['name' => 'Decor', 'slug' => 'decor'],
                    ['name' => 'Kitchen', 'slug' => 'kitchen'],
                    ['name' => 'Garden', 'slug' => 'garden'],
                    ['name' => 'Tools', 'slug' => 'tools'],
                ],
            ],
            [
                'name' => 'Toys & Games',
                'slug' => 'toys-games',
                'description' => 'Toys and games for all ages',
                'children' => [
                    ['name' => 'Baby & Toddler', 'slug' => 'baby-toddler'],
                    ['name' => 'Board Games', 'slug' => 'board-games'],
                    ['name' => 'Puzzles', 'slug' => 'puzzles'],
                ],
            ],
            [
                'name' => 'Sports & Outdoors',
                'slug' => 'sports-outdoors',
                'description' => 'Sports equipment and outdoor gear',
                'children' => [
                    ['name' => 'Fitness', 'slug' => 'fitness'],
                    ['name' => 'Camping', 'slug' => 'camping'],
                    ['name' => 'Bicycles', 'slug' => 'bicycles'],
                ],
            ],
            [
                'name' => 'Other',
                'slug' => 'other',
                'description' => 'Items that don\'t fit other categories',
            ],
        ];

        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);

            $category = Category::firstOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );

            foreach ($children as $childData) {
                $childData['parent_id'] = $category->id;
                Category::firstOrCreate(
                    ['slug' => $childData['slug']],
                    $childData
                );
            }
        }
    }
}
