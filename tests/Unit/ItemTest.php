<?php

use App\Enums\ItemStatus;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;

describe('photo management', function () {
    test('hasPhotos returns true when item has photos', function () {
        $item = new Item(['photos' => ['photo1.jpg', 'photo2.jpg']]);

        expect($item->hasPhotos())->toBeTrue();
    });

    test('hasPhotos returns false when photos array is null', function () {
        $item = new Item(['photos' => null]);

        expect($item->hasPhotos())->toBeFalse();
    });

    test('hasPhotos returns false when photos array is empty', function () {
        $item = new Item(['photos' => []]);

        expect($item->hasPhotos())->toBeFalse();
    });

    test('getPhotoUrl returns storage URL for local photos', function () {
        Storage::shouldReceive('disk')->with('public')->andReturnSelf();
        Storage::shouldReceive('url')->with('items/photo.jpg')->andReturn('/storage/items/photo.jpg');

        $item = new Item(['photos' => ['items/photo.jpg']]);
        $url = $item->getPhotoUrl(0);

        expect($url)->toBe('/storage/items/photo.jpg');
    });

    test('getPhotoUrl returns external URL for HTTPS photos', function () {
        $externalUrl = 'https://example.com/photo.jpg';
        $item = new Item(['photos' => [$externalUrl]]);

        $url = $item->getPhotoUrl(0);

        expect($url)->toBe($externalUrl);
    });

    test('getPhotoUrl returns null for invalid index', function () {
        $item = new Item(['photos' => ['photo1.jpg']]);

        expect($item->getPhotoUrl(5))->toBeNull();
    });

    test('getPhotoUrl returns null when photos is null', function () {
        $item = new Item(['photos' => null]);

        expect($item->getPhotoUrl(0))->toBeNull();
    });

    test('getPhotoUrl returns null when photo at index is empty string', function () {
        $item = new Item(['photos' => ['']]);

        expect($item->getPhotoUrl(0))->toBeNull();
    });

    test('getFirstPhotoUrl returns first photo URL', function () {
        Storage::shouldReceive('disk')->with('public')->andReturnSelf();
        Storage::shouldReceive('url')->with('photo1.jpg')->andReturn('/storage/photo1.jpg');

        $item = new Item(['photos' => ['photo1.jpg', 'photo2.jpg']]);
        $url = $item->getFirstPhotoUrl();

        expect($url)->toBe('/storage/photo1.jpg');
    });

    test('getFirstPhotoUrl returns null when no photos', function () {
        $item = new Item(['photos' => null]);

        expect($item->getFirstPhotoUrl())->toBeNull();
    });

    test('getAllPhotoUrls returns all photo URLs', function () {
        Storage::shouldReceive('disk')->with('public')->andReturnSelf();
        Storage::shouldReceive('url')->with('photo1.jpg')->andReturn('/storage/photo1.jpg');
        Storage::shouldReceive('url')->with('photo2.jpg')->andReturn('/storage/photo2.jpg');
        Storage::shouldReceive('url')->with('photo3.jpg')->andReturn('/storage/photo3.jpg');

        $item = new Item(['photos' => ['photo1.jpg', 'photo2.jpg', 'photo3.jpg']]);
        $urls = $item->getAllPhotoUrls();

        expect($urls)->toHaveCount(3)
            ->and($urls)->toContain('/storage/photo1.jpg')
            ->and($urls)->toContain('/storage/photo2.jpg')
            ->and($urls)->toContain('/storage/photo3.jpg');
    });

    test('getAllPhotoUrls returns empty array when no photos', function () {
        $item = new Item(['photos' => null]);

        expect($item->getAllPhotoUrls())->toBeEmpty();
    });

    test('getAllPhotoUrls handles mix of local and external URLs', function () {
        Storage::shouldReceive('disk')->with('public')->andReturnSelf();
        Storage::shouldReceive('url')->with('items/local-photo.jpg')->andReturn('/storage/items/local-photo.jpg');

        $item = new Item([
            'photos' => [
                'items/local-photo.jpg',
                'https://example.com/external-photo.jpg',
            ],
        ]);

        $urls = $item->getAllPhotoUrls();

        expect($urls)->toHaveCount(2)
            ->and($urls[0])->toBe('/storage/items/local-photo.jpg')
            ->and($urls[1])->toBe('https://example.com/external-photo.jpg');
    });

    test('getAllPhotoUrls filters out null URLs', function () {
        Storage::shouldReceive('disk')->with('public')->andReturnSelf();
        Storage::shouldReceive('url')->with('photo1.jpg')->andReturn('/storage/photo1.jpg');

        $item = new Item(['photos' => ['photo1.jpg', '', null]]);
        $urls = $item->getAllPhotoUrls();

        expect($urls)->toHaveCount(1)
            ->and($urls[0])->toBe('/storage/photo1.jpg');
    });

    test('getFirstPhotoUrlOrPlaceholder returns photo URL when exists', function () {
        Storage::shouldReceive('disk')->with('public')->andReturnSelf();
        Storage::shouldReceive('url')->with('photo.jpg')->andReturn('/storage/photo.jpg');

        $item = new Item(['photos' => ['photo.jpg']]);
        $url = $item->getFirstPhotoUrlOrPlaceholder();

        expect($url)->toBe('/storage/photo.jpg');
    });

    test('getFirstPhotoUrlOrPlaceholder returns placeholder when no photos', function () {
        $item = new Item(['photos' => null]);

        $url = $item->getFirstPhotoUrlOrPlaceholder();

        expect($url)->toBe(Item::PLACEHOLDER_IMAGE_URL);
    });

    test('hasFirstPhoto returns true when first photo exists', function () {
        Storage::shouldReceive('disk')->with('public')->andReturnSelf();
        Storage::shouldReceive('url')->with('photo.jpg')->andReturn('/storage/photo.jpg');

        $item = new Item(['photos' => ['photo.jpg']]);

        expect($item->hasFirstPhoto())->toBeTrue();
    });

    test('hasFirstPhoto returns false when no photos', function () {
        $item = new Item(['photos' => null]);

        expect($item->hasFirstPhoto())->toBeFalse();
    });

    test('hasFirstPhoto returns false when photos array is empty', function () {
        $item = new Item(['photos' => []]);

        expect($item->hasFirstPhoto())->toBeFalse();
    });

    test('hasFirstPhoto returns false when first photo is empty string', function () {
        $item = new Item(['photos' => ['']]);

        expect($item->hasFirstPhoto())->toBeFalse();
    });
});

describe('status attributes', function () {
    test('status is cast to ItemStatus enum', function () {
        $item = new Item(['status' => ItemStatus::Available]);

        expect($item->status)->toBeInstanceOf(ItemStatus::class)
            ->and($item->status)->toBe(ItemStatus::Available);
    });

    test('photos are cast to array', function () {
        $item = new Item(['photos' => ['photo1.jpg', 'photo2.jpg']]);

        expect($item->photos)->toBeArray()
            ->and($item->photos)->toHaveCount(2);
    });
});

describe('constants', function () {
    test('placeholder image URL is properly formatted', function () {
        expect(Item::PLACEHOLDER_IMAGE_URL)
            ->toStartWith('https://')
            ->toContain('placehold.co')
            ->toContain('600x400');
    });
});
