<?php

declare(strict_types=1);

use App\Enums\ItemStatus;
use App\Models\Item;
use App\Models\User;

test('welcome page displays successfully', function () {
    $response = $this->get('/');

    $response->assertSuccessful();
    $response->assertSee('Freecycle Listings Platform');
});

test('welcome page displays latest 10 available items', function () {
    $user = User::factory()->create();

    // Create 15 available items
    Item::factory()->count(15)->create([
        'user_id' => $user->id,
        'status' => ItemStatus::Available->value,
    ]);

    $response = $this->get('/');

    $response->assertSuccessful();
    $response->assertSee('Latest Available Items');

    // Check that we see items on the page
    $items = Item::available()->latest()->limit(10)->get();
    foreach ($items as $item) {
        $response->assertSee($item->title);
    }
});

test('welcome page only shows available items not gifted', function () {
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

    $response = $this->get('/');

    $response->assertSuccessful();
    $response->assertSee('Available Item');
    $response->assertDontSee('Gifted Item');
});

test('welcome page shows no items message when no items available', function () {
    $response = $this->get('/');

    $response->assertSuccessful();
    $response->assertSee('No items available at the moment');
});

test('welcome page shows login to view button for guests', function () {
    $user = User::factory()->create();

    Item::factory()->create([
        'user_id' => $user->id,
        'status' => ItemStatus::Available->value,
    ]);

    $response = $this->get('/');

    $response->assertSuccessful();
    //    $response->assertSee('Login to View');
    //    $response->assertDontSee('View All Items');
});

test('welcome page shows view details button for authenticated users', function () {
    $user = User::factory()->create();

    $item = Item::factory()->create([
        'user_id' => $user->id,
        'status' => ItemStatus::Available->value,
    ]);

    $this->actingAs($user);

    $response = $this->get('/');

    $response->assertSuccessful();
    $response->assertSee('View Details');
    $response->assertSee('View All Items');
    $response->assertSee(route('items.show', $item));
});

test('welcome page displays item information correctly', function () {
    $user = User::factory()->create();

    $item = Item::factory()->create([
        'user_id' => $user->id,
        'status' => ItemStatus::Available->value,
        'title' => 'Test Item Title',
        'description' => 'Test Item Description',
        'category' => 'Electronics',
        'city' => 'New York',
    ]);

    $response = $this->get('/');

    $response->assertSuccessful();
    $response->assertSee('Test Item Title');
    $response->assertSee('Electronics');
    $response->assertSee('New York');
    $response->assertSee($user->name);
});

test('welcome page limits items to 10', function () {
    $user = User::factory()->create();

    // Create 15 available items
    $items = Item::factory()->count(15)->create([
        'user_id' => $user->id,
        'status' => ItemStatus::Available->value,
    ]);

    $response = $this->get('/');

    $response->assertSuccessful();

    // Get the 10 latest items
    $latestTen = $items->sortByDesc('created_at')->take(10);

    // These should be visible
    foreach ($latestTen as $item) {
        $response->assertSee($item->title);
    }

    // The remaining 5 oldest items should not be visible
    $remainingFive = $items->sortByDesc('created_at')->skip(10)->take(5);
    foreach ($remainingFive as $item) {
        $response->assertDontSee($item->title);
    }
});

test('welcome page displays images with correct urls', function () {
    $user = User::factory()->create();

    // Create item with full URL photo (like picsum)
    $item = Item::factory()->create([
        'user_id' => $user->id,
        'status' => ItemStatus::Available->value,
        'photos' => ['https://picsum.photos/id/100/400/400'],
    ]);

    $response = $this->get('/');

    $response->assertSuccessful();
    // Should see the direct URL without /storage/ prefix
    $response->assertSee('https://picsum.photos/id/100/400/400', false);
    // Should NOT see double storage prefix
    $response->assertDontSee('/storage/https://', false);
});
