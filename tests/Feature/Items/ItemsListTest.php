<?php

declare(strict_types=1);

use App\Enums\ItemStatus;
use App\Models\Item;
use App\Models\User;
use Livewire\Volt\Volt;

test('guests cannot access items list - redirected to login', function () {
    $response = $this->get(route('items.index'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view items list', function () {
    $user = User::factory()->create();
    Item::factory()->count(3)->create(['user_id' => $user->id]);

    $this->actingAs($user);

    $response = $this->get(route('items.index'));

    $response->assertSuccessful();
    $response->assertSee('All Items');
});

test('items list displays items with correct information', function () {
    $user = User::factory()->create();
    $category = \App\Models\Category::factory()->create(['name' => 'Electronics']);
    $city = \App\Models\City::factory()->create(['name' => 'New York']);

    $item = Item::factory()->create([
        'user_id' => $user->id,
        'title' => 'Test Item Title',
        'description' => 'Test Item Description',
        'category_id' => $category->id,
        'city_id' => $city->id,
        'status' => ItemStatus::Available->value,
    ]);

    $this->actingAs($user);

    $response = $this->get(route('items.index'));

    $response->assertSuccessful();
    $response->assertSee('Test Item Title');
    $response->assertSee('Electronics');
    $response->assertSee('New York');
    $response->assertSee('Available');
});

test('items list search functionality works', function () {
    $user = User::factory()->create();
    $matchingItem = Item::factory()->create([
        'user_id' => $user->id,
        'title' => 'Vintage Record Player',
    ]);
    $nonMatchingItem = Item::factory()->create([
        'user_id' => $user->id,
        'title' => 'Modern Laptop',
    ]);

    $this->actingAs($user);

    Volt::test('items.index')
        ->set('search', 'Vintage')
        ->assertSee('Vintage Record Player')
        ->assertDontSee('Modern Laptop');
});

test('items list filters by category', function () {
    $user = User::factory()->create();
    $electronicsCategory = \App\Models\Category::factory()->create(['name' => 'Electronics']);
    $booksCategory = \App\Models\Category::factory()->create(['name' => 'Books']);

    $electronicsItem = Item::factory()->create([
        'user_id' => $user->id,
        'category_id' => $electronicsCategory->id,
        'title' => 'Smartphone',
    ]);
    $booksItem = Item::factory()->create([
        'user_id' => $user->id,
        'category_id' => $booksCategory->id,
        'title' => 'Novel',
    ]);

    $this->actingAs($user);

    Volt::test('items.index')
        ->set('category', $electronicsCategory->id)
        ->assertSee('Smartphone')
        ->assertDontSee('Novel');
});

test('items list filters by city', function () {
    $user = User::factory()->create();
    $nyCity = \App\Models\City::factory()->create(['name' => 'New York']);
    $laCity = \App\Models\City::factory()->create(['name' => 'Los Angeles']);

    $nyItem = Item::factory()->create([
        'user_id' => $user->id,
        'city_id' => $nyCity->id,
        'title' => 'NY Item',
    ]);
    $laItem = Item::factory()->create([
        'user_id' => $user->id,
        'city_id' => $laCity->id,
        'title' => 'LA Item',
    ]);

    $this->actingAs($user);

    Volt::test('items.index')
        ->set('city', $nyCity->id)
        ->assertSee('NY Item')
        ->assertDontSee('LA Item');
});

test('items list filters by status', function () {
    $user = User::factory()->create();
    $availableItem = Item::factory()->create([
        'user_id' => $user->id,
        'status' => ItemStatus::Available->value,
        'title' => 'Available Item',
    ]);
    $giftedItem = Item::factory()->create([
        'user_id' => $user->id,
        'status' => ItemStatus::Gifted->value,
        'title' => 'Gifted Item',
    ]);

    $this->actingAs($user);

    Volt::test('items.index')
        ->set('status', (string) ItemStatus::Available->value)
        ->assertSee('Available Item')
        ->assertDontSee('Gifted Item');
});

test('items list sorts by newest first', function () {
    $user = User::factory()->create();
    $oldItem = Item::factory()->create([
        'user_id' => $user->id,
        'title' => 'Old Item',
        'created_at' => now()->subDays(5),
    ]);
    $newItem = Item::factory()->create([
        'user_id' => $user->id,
        'title' => 'New Item',
        'created_at' => now(),
    ]);

    $this->actingAs($user);

    $response = $this->get(route('items.index').'?sort=newest');

    $response->assertSuccessful();
    $response->assertSeeInOrder(['New Item', 'Old Item']);
});

test('items list resets filters', function () {
    $user = User::factory()->create();
    Item::factory()->count(5)->create(['user_id' => $user->id]);

    $this->actingAs($user);

    Volt::test('items.index')
        ->set('search', 'test')
        ->set('category', 'Electronics')
        ->set('city', 'New York')
        ->set('status', (string) ItemStatus::Available->value)
        ->call('resetFilters')
        ->assertSet('search', '')
        ->assertSet('category', '')
        ->assertSet('city', '')
        ->assertSet('status', '')
        ->assertSet('sort', 'newest');
});

test('items list paginates results', function () {
    $user = User::factory()->create();
    Item::factory()->count(15)->create(['user_id' => $user->id]);

    $this->actingAs($user);

    $response = $this->get(route('items.index'));

    $response->assertSuccessful();
    // Should show pagination since we have more than 12 items (page size is 12)
    // Check for pagination by looking for page 2 link
    $response->assertSee('?page=2', false);
});

test('items list displays no items message when empty', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->get(route('items.index'));

    $response->assertSuccessful();
    $response->assertSee('No items found');
});

test('items list shows view details button', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create([
        'user_id' => $user->id,
        'title' => 'Test Item',
    ]);

    $this->actingAs($user);

    $response = $this->get(route('items.index'));

    $response->assertSuccessful();
    $response->assertSee('View Details');
    $response->assertSee(route('items.show', $item));
});

test('items list displays images with correct urls', function () {
    $user = User::factory()->create();

    // Create item with full URL photo (like picsum)
    $item = Item::factory()->create([
        'user_id' => $user->id,
        'photos' => ['https://picsum.photos/id/100/400/400'],
    ]);

    $this->actingAs($user);

    $response = $this->get(route('items.index'));

    $response->assertSuccessful();
    // Should see the direct URL without /storage/ prefix
    $response->assertSee('https://picsum.photos/id/100/400/400', false);
    // Should NOT see double storage prefix
    $response->assertDontSee('/storage/https://', false);
});
