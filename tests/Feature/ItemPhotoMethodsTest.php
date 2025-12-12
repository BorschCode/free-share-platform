<?php

declare(strict_types=1);

use App\Models\Item;
use App\Models\User;

test('hasPhotos returns true when item has photos', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create([
        'user_id' => $user->id,
        'photos' => ['https://picsum.photos/id/100/400/400'],
    ]);

    expect($item->hasPhotos())->toBeTrue();
});

test('hasPhotos returns false when item has no photos', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create([
        'user_id' => $user->id,
        'photos' => null,
    ]);

    expect($item->hasPhotos())->toBeFalse();
});

test('hasPhotos returns false when photos array is empty', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create([
        'user_id' => $user->id,
        'photos' => [],
    ]);

    expect($item->hasPhotos())->toBeFalse();
});

test('getPhotoUrl returns full url for external photos', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create([
        'user_id' => $user->id,
        'photos' => ['https://picsum.photos/id/100/400/400'],
    ]);

    expect($item->getPhotoUrl(0))->toBe('https://picsum.photos/id/100/400/400');
});

test('getPhotoUrl returns storage url for local photos', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create([
        'user_id' => $user->id,
        'photos' => ['photos/item-123.jpg'],
    ]);

    $url = $item->getPhotoUrl(0);
    expect($url)->toContain('/storage/photos/item-123.jpg');
});

test('getPhotoUrl returns null when index does not exist', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create([
        'user_id' => $user->id,
        'photos' => ['https://picsum.photos/id/100/400/400'],
    ]);

    expect($item->getPhotoUrl(5))->toBeNull();
});

test('getPhotoUrl returns null when photos array is empty', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create([
        'user_id' => $user->id,
        'photos' => [],
    ]);

    expect($item->getPhotoUrl(0))->toBeNull();
});

test('getFirstPhotoUrl returns first photo url', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create([
        'user_id' => $user->id,
        'photos' => [
            'https://picsum.photos/id/100/400/400',
            'https://picsum.photos/id/101/400/400',
        ],
    ]);

    expect($item->getFirstPhotoUrl())->toBe('https://picsum.photos/id/100/400/400');
});

test('getFirstPhotoUrl returns null when no photos', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create([
        'user_id' => $user->id,
        'photos' => null,
    ]);

    expect($item->getFirstPhotoUrl())->toBeNull();
});

test('getFirstPhotoUrlOrPlaceholder returns photo url when photo exists', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create([
        'user_id' => $user->id,
        'photos' => ['https://picsum.photos/id/100/400/400'],
    ]);

    expect($item->getFirstPhotoUrlOrPlaceholder())->toBe('https://picsum.photos/id/100/400/400');
});

test('getFirstPhotoUrlOrPlaceholder returns placeholder when no photos', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create([
        'user_id' => $user->id,
        'photos' => null,
    ]);

    $url = $item->getFirstPhotoUrlOrPlaceholder();
    expect($url)->toContain('placeholder')
        ->and($url)->toContain('No+Image');
});

test('hasFirstPhoto returns true when first photo exists', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create([
        'user_id' => $user->id,
        'photos' => ['https://picsum.photos/id/100/400/400'],
    ]);

    expect($item->hasFirstPhoto())->toBeTrue();
});

test('hasFirstPhoto returns false when no photos', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create([
        'user_id' => $user->id,
        'photos' => [],
    ]);

    expect($item->hasFirstPhoto())->toBeFalse();
});

test('getAllPhotoUrls returns all photo urls', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create([
        'user_id' => $user->id,
        'photos' => [
            'https://picsum.photos/id/100/400/400',
            'https://picsum.photos/id/101/400/400',
            'https://picsum.photos/id/102/400/400',
        ],
    ]);

    $urls = $item->getAllPhotoUrls();
    expect($urls)->toHaveCount(3)
        ->and($urls[0])->toBe('https://picsum.photos/id/100/400/400')
        ->and($urls[1])->toBe('https://picsum.photos/id/101/400/400')
        ->and($urls[2])->toBe('https://picsum.photos/id/102/400/400');
});

test('getAllPhotoUrls returns empty array when no photos', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create([
        'user_id' => $user->id,
        'photos' => null,
    ]);

    expect($item->getAllPhotoUrls())->toBeArray()
        ->and($item->getAllPhotoUrls())->toBeEmpty();
});

test('getAllPhotoUrls filters out empty photo strings', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create([
        'user_id' => $user->id,
        'photos' => [
            'https://picsum.photos/id/100/400/400',
            '',
            'https://picsum.photos/id/101/400/400',
        ],
    ]);

    $urls = $item->getAllPhotoUrls();
    expect($urls)->toHaveCount(2)
        ->and($urls[0])->toBe('https://picsum.photos/id/100/400/400')
        ->and($urls[1])->toBe('https://picsum.photos/id/101/400/400');
});
