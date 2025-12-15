<?php

namespace Database\Factories;

use App\Enums\ItemStatus;
use App\Models\Category;
use App\Models\City;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->unique()->words(3, true);

        $imageId = $this->faker->numberBetween(1, 1000);

        $width = $this->faker->randomElement([400, 500, 600]);
        $height = $this->faker->randomElement([300, 400, 450]);

        $photosArray = [];
        $photoCount = $this->faker->numberBetween(1, 3);
        for ($i = 0; $i < $photoCount; $i++) {
            $currentImageId = $imageId + $i; // Use unique IDs for each photo in the array
            $photosArray[] = "https://picsum.photos/id/{$currentImageId}/{$width}/{$height}";
        }

        $randomStatus = $this->faker->randomElement(ItemStatus::cases());

        return [
            'title' => $title,
            'description' => $this->faker->paragraph(3),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'city_id' => City::inRandomOrder()->first()?->id ?? City::factory(),
            'weight' => $this->faker->randomFloat(2, 0.1, 50),
            'dimensions' => $this->faker->numberBetween(10, 100).'x'.$this->faker->numberBetween(10, 100).'x'.$this->faker->numberBetween(10, 100),
            'photos' => $photosArray,
            'status' => $randomStatus->value,
        ];
    }
}
