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
                'name' => 'Furniture & Home',
                'slug' => 'furniture-home',
                'description' => 'Furniture and home furnishings',
                'children' => [
                    ['name' => 'Sofas & Chairs', 'slug' => 'sofas-chairs', 'description' => 'Couches, armchairs, recliners'],
                    ['name' => 'Tables & Desks', 'slug' => 'tables-desks', 'description' => 'Dining tables, coffee tables, desks'],
                    ['name' => 'Beds & Mattresses', 'slug' => 'beds-mattresses', 'description' => 'Bed frames, mattresses, bedding'],
                    ['name' => 'Storage & Shelving', 'slug' => 'storage-shelving', 'description' => 'Bookcases, wardrobes, cabinets'],
                    ['name' => 'Outdoor Furniture', 'slug' => 'outdoor-furniture', 'description' => 'Patio sets, garden furniture'],
                ],
            ],
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Electronic devices and appliances',
                'children' => [
                    ['name' => 'Computers & Laptops', 'slug' => 'computers-laptops', 'description' => 'Desktop computers, laptops, monitors'],
                    ['name' => 'Phones & Tablets', 'slug' => 'phones-tablets', 'description' => 'Mobile phones, tablets, accessories'],
                    ['name' => 'TVs & Audio', 'slug' => 'tvs-audio', 'description' => 'Televisions, speakers, sound systems'],
                    ['name' => 'Home Appliances', 'slug' => 'home-appliances', 'description' => 'Microwaves, vacuum cleaners, fans'],
                    ['name' => 'Gaming', 'slug' => 'gaming', 'description' => 'Gaming consoles, controllers, games'],
                ],
            ],
            [
                'name' => 'Books & Media',
                'slug' => 'books-media',
                'description' => 'Books, magazines, and entertainment',
                'children' => [
                    ['name' => 'Fiction Books', 'slug' => 'fiction-books', 'description' => 'Novels, short stories, literature'],
                    ['name' => 'Non-Fiction Books', 'slug' => 'non-fiction-books', 'description' => 'Biography, history, self-help'],
                    ['name' => 'Children\'s Books', 'slug' => 'childrens-books', 'description' => 'Picture books, young adult novels'],
                    ['name' => 'Comics & Magazines', 'slug' => 'comics-magazines', 'description' => 'Comic books, magazines, periodicals'],
                    ['name' => 'Movies & Music', 'slug' => 'movies-music', 'description' => 'DVDs, Blu-rays, CDs, vinyl records'],
                ],
            ],
            [
                'name' => 'Clothing & Accessories',
                'slug' => 'clothing-accessories',
                'description' => 'Apparel and fashion items',
                'children' => [
                    ['name' => 'Women\'s Clothing', 'slug' => 'womens-clothing', 'description' => 'Dresses, tops, pants, jackets'],
                    ['name' => 'Men\'s Clothing', 'slug' => 'mens-clothing', 'description' => 'Shirts, pants, suits, outerwear'],
                    ['name' => 'Kids Clothing', 'slug' => 'kids-clothing', 'description' => 'Baby clothes, children\'s apparel'],
                    ['name' => 'Shoes', 'slug' => 'shoes', 'description' => 'Sneakers, boots, sandals, dress shoes'],
                    ['name' => 'Bags & Accessories', 'slug' => 'bags-accessories', 'description' => 'Handbags, backpacks, jewelry, watches'],
                ],
            ],
            [
                'name' => 'Baby & Kids',
                'slug' => 'baby-kids',
                'description' => 'Items for babies and children',
                'children' => [
                    ['name' => 'Baby Gear', 'slug' => 'baby-gear', 'description' => 'Strollers, car seats, high chairs'],
                    ['name' => 'Toys', 'slug' => 'toys', 'description' => 'Action figures, dolls, building blocks'],
                    ['name' => 'Games & Puzzles', 'slug' => 'games-puzzles', 'description' => 'Board games, card games, jigsaw puzzles'],
                    ['name' => 'School Supplies', 'slug' => 'school-supplies', 'description' => 'Backpacks, notebooks, art supplies'],
                ],
            ],
            [
                'name' => 'Kitchen & Dining',
                'slug' => 'kitchen-dining',
                'description' => 'Kitchen items and dining ware',
                'children' => [
                    ['name' => 'Cookware', 'slug' => 'cookware', 'description' => 'Pots, pans, baking sheets'],
                    ['name' => 'Dishes & Glassware', 'slug' => 'dishes-glassware', 'description' => 'Plates, bowls, cups, glasses'],
                    ['name' => 'Cutlery & Utensils', 'slug' => 'cutlery-utensils', 'description' => 'Knives, forks, spoons, cooking tools'],
                    ['name' => 'Small Appliances', 'slug' => 'small-appliances', 'description' => 'Blenders, toasters, coffee makers'],
                ],
            ],
            [
                'name' => 'Sports & Fitness',
                'slug' => 'sports-fitness',
                'description' => 'Sports equipment and fitness gear',
                'children' => [
                    ['name' => 'Exercise Equipment', 'slug' => 'exercise-equipment', 'description' => 'Weights, yoga mats, exercise bikes'],
                    ['name' => 'Bicycles & Scooters', 'slug' => 'bicycles-scooters', 'description' => 'Bikes, scooters, skateboards'],
                    ['name' => 'Outdoor Sports', 'slug' => 'outdoor-sports', 'description' => 'Camping gear, fishing equipment, sports balls'],
                    ['name' => 'Athletic Wear', 'slug' => 'athletic-wear', 'description' => 'Workout clothes, sneakers, sports gear'],
                ],
            ],
            [
                'name' => 'Garden & Outdoor',
                'slug' => 'garden-outdoor',
                'description' => 'Garden tools and outdoor items',
                'children' => [
                    ['name' => 'Plants & Seeds', 'slug' => 'plants-seeds', 'description' => 'Potted plants, seeds, bulbs'],
                    ['name' => 'Garden Tools', 'slug' => 'garden-tools', 'description' => 'Shovels, rakes, hoses, lawn mowers'],
                    ['name' => 'Pots & Planters', 'slug' => 'pots-planters', 'description' => 'Flower pots, planters, garden containers'],
                    ['name' => 'Outdoor Decor', 'slug' => 'outdoor-decor', 'description' => 'Garden statues, lights, decorations'],
                ],
            ],
            [
                'name' => 'Arts & Crafts',
                'slug' => 'arts-crafts',
                'description' => 'Art supplies and craft materials',
                'children' => [
                    ['name' => 'Art Supplies', 'slug' => 'art-supplies', 'description' => 'Paints, brushes, canvases, easels'],
                    ['name' => 'Craft Materials', 'slug' => 'craft-materials', 'description' => 'Fabric, yarn, beads, craft tools'],
                    ['name' => 'Sewing & Knitting', 'slug' => 'sewing-knitting', 'description' => 'Sewing machines, knitting needles, patterns'],
                ],
            ],
            [
                'name' => 'Office & Stationery',
                'slug' => 'office-stationery',
                'description' => 'Office supplies and stationery',
                'children' => [
                    ['name' => 'Office Furniture', 'slug' => 'office-furniture', 'description' => 'Desks, chairs, filing cabinets'],
                    ['name' => 'Stationery', 'slug' => 'stationery', 'description' => 'Pens, notebooks, paper, folders'],
                    ['name' => 'Office Equipment', 'slug' => 'office-equipment', 'description' => 'Printers, scanners, shredders'],
                ],
            ],
            [
                'name' => 'Pet Supplies',
                'slug' => 'pet-supplies',
                'description' => 'Items for pets',
                'children' => [
                    ['name' => 'Pet Accessories', 'slug' => 'pet-accessories', 'description' => 'Collars, leashes, bowls, beds'],
                    ['name' => 'Pet Toys', 'slug' => 'pet-toys', 'description' => 'Dog toys, cat toys, play equipment'],
                    ['name' => 'Pet Cages & Carriers', 'slug' => 'pet-cages-carriers', 'description' => 'Crates, carriers, cages, aquariums'],
                ],
            ],
            [
                'name' => 'Free & Miscellaneous',
                'slug' => 'free-miscellaneous',
                'description' => 'Various free items and miscellaneous',
                'children' => [
                    ['name' => 'Moving Boxes', 'slug' => 'moving-boxes', 'description' => 'Cardboard boxes, packing materials'],
                    ['name' => 'Building Materials', 'slug' => 'building-materials', 'description' => 'Wood, tiles, leftover materials'],
                    ['name' => 'Other Items', 'slug' => 'other-items', 'description' => 'Items that don\'t fit elsewhere'],
                ],
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
