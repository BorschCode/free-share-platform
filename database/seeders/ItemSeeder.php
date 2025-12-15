<?php

namespace Database\Seeders;

use App\Enums\ItemStatus;
use App\Models\Category;
use App\Models\City;
use App\Models\Item;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $tags = Tag::all();

        // Get categories by slug for easy access
        $categories = [
            'sofas-chairs' => Category::where('slug', 'sofas-chairs')->first(),
            'tables-desks' => Category::where('slug', 'tables-desks')->first(),
            'beds-mattresses' => Category::where('slug', 'beds-mattresses')->first(),
            'storage-shelving' => Category::where('slug', 'storage-shelving')->first(),
            'computers-laptops' => Category::where('slug', 'computers-laptops')->first(),
            'tvs-audio' => Category::where('slug', 'tvs-audio')->first(),
            'home-appliances' => Category::where('slug', 'home-appliances')->first(),
            'fiction-books' => Category::where('slug', 'fiction-books')->first(),
            'non-fiction-books' => Category::where('slug', 'non-fiction-books')->first(),
            'childrens-books' => Category::where('slug', 'childrens-books')->first(),
            'womens-clothing' => Category::where('slug', 'womens-clothing')->first(),
            'mens-clothing' => Category::where('slug', 'mens-clothing')->first(),
            'baby-gear' => Category::where('slug', 'baby-gear')->first(),
            'toys' => Category::where('slug', 'toys')->first(),
            'games-puzzles' => Category::where('slug', 'games-puzzles')->first(),
            'cookware' => Category::where('slug', 'cookware')->first(),
            'dishes-glassware' => Category::where('slug', 'dishes-glassware')->first(),
            'exercise-equipment' => Category::where('slug', 'exercise-equipment')->first(),
            'bicycles-scooters' => Category::where('slug', 'bicycles-scooters')->first(),
            'garden-tools' => Category::where('slug', 'garden-tools')->first(),
            'plants-seeds' => Category::where('slug', 'plants-seeds')->first(),
            'moving-boxes' => Category::where('slug', 'moving-boxes')->first(),
        ];

        $cities = City::all();

        $realisticItems = [
            // Furniture
            [
                'title' => 'Blue IKEA Sofa - Great Condition',
                'description' => 'Moving out of state and need to find a good home for this comfortable 3-seater sofa. It\'s in excellent condition, no stains or tears. From a smoke-free, pet-free home. Pickup only - you\'ll need a truck or van.',
                'category' => $categories['sofas-chairs'],
                'weight' => 45.5,
                'dimensions' => '210x90x85cm',
                'status' => ItemStatus::Available,
            ],
            [
                'title' => 'Wooden Coffee Table - Needs Refinishing',
                'description' => 'Solid wood coffee table that has seen better days. Surface is scratched and could use refinishing, but the structure is very sturdy. Great project piece for someone handy! Dimensions: 120x60x45cm.',
                'category' => $categories['tables-desks'],
                'weight' => 25.0,
                'dimensions' => '120x60x45cm',
                'status' => ItemStatus::Available,
            ],
            [
                'title' => 'Queen Size Bed Frame - Metal',
                'description' => 'Black metal bed frame, queen size. Easy to assemble/disassemble. A few minor scratches but overall in good shape. Mattress not included. Must pick up by end of week as I\'m moving.',
                'category' => $categories['beds-mattresses'],
                'weight' => 30.0,
                'dimensions' => '160x200x40cm',
                'status' => ItemStatus::Available,
            ],
            [
                'title' => 'IKEA Billy Bookcase - White',
                'description' => 'Classic Billy bookcase from IKEA. White color, 5 shelves. In good condition with minimal wear. Already disassembled and ready for transport. Hardware included.',
                'category' => $categories['storage-shelving'],
                'weight' => 28.0,
                'dimensions' => '80x28x202cm',
                'status' => ItemStatus::Available,
            ],

            // Electronics
            [
                'title' => 'Dell Laptop - Older Model but Works',
                'description' => 'Dell Inspiron laptop from 2018. Intel i5, 8GB RAM, 256GB SSD. Battery holds charge for about 2 hours. Great for basic tasks like browsing and word processing. Comes with charger. Windows 10 installed and ready to use.',
                'category' => $categories['computers-laptops'],
                'weight' => 2.3,
                'dimensions' => '38x25x2cm',
                'status' => ItemStatus::Available,
            ],
            [
                'title' => '32" Samsung TV - Works Perfect',
                'description' => 'Samsung 32-inch LED TV. Upgraded to a bigger one so giving this away. No issues, picture quality is still great. Includes remote control. No stand included, but has VESA mount holes if you want to wall mount it.',
                'category' => $categories['tvs-audio'],
                'weight' => 8.5,
                'dimensions' => '73x43x8cm',
                'status' => ItemStatus::Available,
            ],
            [
                'title' => 'Microwave Oven - Still Working',
                'description' => 'White microwave oven, 900W. Works perfectly fine, just upgrading to a newer model. Clean and ready to use. About 5 years old but barely used as I don\'t cook much.',
                'category' => $categories['home-appliances'],
                'weight' => 15.0,
                'dimensions' => '50x30x35cm',
                'status' => ItemStatus::Available,
            ],

            // Books
            [
                'title' => 'Box of Mystery Novels - About 20 Books',
                'description' => 'Collection of mystery and thriller novels. Authors include Agatha Christie, James Patterson, and more. All in readable condition, some are paperback, some hardcover. Great for mystery lovers! Pick up only.',
                'category' => $categories['fiction-books'],
                'weight' => 12.0,
                'status' => ItemStatus::Available,
            ],
            [
                'title' => 'Self-Help and Business Books',
                'description' => 'About 15 self-help and business books including "Atomic Habits", "Think and Grow Rich", etc. Some highlights and notes inside. Take all or just the ones you want.',
                'category' => $categories['non-fiction-books'],
                'weight' => 8.5,
                'status' => ItemStatus::Available,
            ],
            [
                'title' => 'Kids Picture Books - Set of 25',
                'description' => 'Large collection of children\'s picture books for ages 3-7. Includes classics like "The Very Hungry Caterpillar" and many more. My kids have outgrown them. All in good condition.',
                'category' => $categories['childrens-books'],
                'weight' => 6.0,
                'status' => ItemStatus::Available,
            ],

            // Clothing
            [
                'title' => 'Women\'s Winter Coats - Size M',
                'description' => 'Three winter coats, all size Medium. Black peacoat, gray puffer jacket, and brown wool coat. All clean and in wearable condition. Some signs of wear but plenty of life left in them.',
                'category' => $categories['womens-clothing'],
                'weight' => 3.5,
                'status' => ItemStatus::Available,
            ],
            [
                'title' => 'Men\'s Dress Shirts - Various Sizes',
                'description' => 'About 10 men\'s dress shirts in sizes M-L. Various colors and patterns. From my husband\'s closet cleanout. All have been washed and are ready to wear. Some are from Gap, Banana Republic.',
                'category' => $categories['mens-clothing'],
                'weight' => 2.0,
                'status' => ItemStatus::Available,
            ],

            // Baby & Kids
            [
                'title' => 'Baby Stroller - Graco Model',
                'description' => 'Graco baby stroller in good condition. Used for our first child. Folds up easily for transport. Has cup holders and storage basket. Cleaned and sanitized. Small stain on the seat but otherwise great!',
                'category' => $categories['baby-gear'],
                'weight' => 10.0,
                'dimensions' => '95x60x105cm',
                'status' => ItemStatus::Available,
            ],
            [
                'title' => 'Box of LEGO Bricks - Mixed Collection',
                'description' => 'Large box filled with assorted LEGO bricks. Mix of colors and sizes. Some minifigures included. Not sorted but there\'s probably 5-10 lbs of LEGOs here. Great for creative kids!',
                'category' => $categories['toys'],
                'weight' => 5.0,
                'status' => ItemStatus::Available,
            ],
            [
                'title' => 'Board Games - Family Collection',
                'description' => 'Five board games: Monopoly, Scrabble, Uno, Connect Four, and Jenga. All pieces present and accounted for. Boxes show some wear but games are complete and playable. Great for family game night!',
                'category' => $categories['games-puzzles'],
                'weight' => 4.0,
                'status' => ItemStatus::Available,
            ],

            // Kitchen
            [
                'title' => 'Pots and Pans Set - Non-Stick',
                'description' => 'Set of 6 non-stick pots and pans. Some scratching on the cooking surface but still usable. Includes 2 frying pans, 2 sauce pans, and 2 larger pots with lids. Black exterior.',
                'category' => $categories['cookware'],
                'weight' => 8.0,
                'status' => ItemStatus::Available,
            ],
            [
                'title' => 'Dinner Plates and Bowls Set',
                'description' => 'White ceramic dinner set. 8 dinner plates, 8 salad plates, 8 bowls. Simple white design, dishwasher safe. One bowl has a tiny chip but the rest are perfect. Great starter set!',
                'category' => $categories['dishes-glassware'],
                'weight' => 12.0,
                'status' => ItemStatus::Available,
            ],

            // Sports & Fitness
            [
                'title' => 'Yoga Mat and Blocks',
                'description' => 'Purple yoga mat (6mm thick) and two foam yoga blocks. Mat is clean, barely used. I thought I\'d get into yoga but never did. Great for beginners!',
                'category' => $categories['exercise-equipment'],
                'weight' => 2.0,
                'dimensions' => '180x60x0.6cm',
                'status' => ItemStatus::Available,
            ],
            [
                'title' => 'Kids Bicycle - 16 inch wheels',
                'description' => 'Blue kids bike with training wheels. 16-inch wheels, suitable for ages 4-7. Some rust on the chain but otherwise rides fine. Training wheels can be removed. My daughter outgrew it.',
                'category' => $categories['bicycles-scooters'],
                'weight' => 9.0,
                'status' => ItemStatus::Available,
            ],

            // Garden
            [
                'title' => 'Garden Tools Collection',
                'description' => 'Moving and can\'t take these. Includes shovel, rake, hoe, hand trowel, pruning shears, and watering can. Some rust on metal parts but all functional. Take all or pick what you need.',
                'category' => $categories['garden-tools'],
                'weight' => 6.5,
                'status' => ItemStatus::Available,
            ],
            [
                'title' => 'Potted Plants - Succulents',
                'description' => 'Five small succulent plants in ceramic pots. Very low maintenance! Just water once every 2 weeks. Perfect for people who kill plants easily. Pots included.',
                'category' => $categories['plants-seeds'],
                'weight' => 3.0,
                'status' => ItemStatus::Available,
            ],

            // Free Stuff
            [
                'title' => 'Moving Boxes - About 30',
                'description' => 'Just finished moving and have about 30 cardboard boxes in various sizes. Small, medium, and large. Some are a bit crushed but most are in good shape for reuse. Free packing paper included!',
                'category' => $categories['moving-boxes'],
                'weight' => 15.0,
                'status' => ItemStatus::Available,
            ],
        ];

        foreach ($realisticItems as $itemData) {
            $item = Item::create([
                'user_id' => $users->random()->id,
                'title' => $itemData['title'],
                'description' => $itemData['description'],
                'category_id' => $itemData['category']?->id,
                'city_id' => $cities->random()->id,
                'weight' => $itemData['weight'] ?? null,
                'dimensions' => $itemData['dimensions'] ?? null,
                'photos' => $this->generatePlaceholderPhotos(),
                'status' => $itemData['status'] ?? ItemStatus::Available,
            ]);

            // Attach random 0-3 tags
            $item->tags()->attach(
                $tags->random(mt_rand(0, 3))->pluck('id')->toArray()
            );
        }
    }

    private function generatePlaceholderPhotos(): array
    {
        $photoCount = mt_rand(1, 3);
        $photos = [];
        $imageId = mt_rand(1, 1000);

        for ($i = 0; $i < $photoCount; $i++) {
            $currentImageId = $imageId + $i;
            $photos[] = "https://picsum.photos/id/{$currentImageId}/800/600";
        }

        return $photos;
    }
}
