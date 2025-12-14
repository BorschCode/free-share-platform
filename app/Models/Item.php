<?php

namespace App\Models;

use App\Enums\ItemStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property string $category
 * @property string $city
 * @property numeric|null $weight
 * @property string|null $dimensions
 * @property array<array-key, mixed>|null $photos
 * @property ItemStatus $status 1: Available, 2: Gifted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vote> $votes
 * @property-read int|null $votes_count
 *
 * @method static Builder<static>|Item available()
 * @method static Builder<static>|Item byStatus(\App\Enums\ItemStatus $status)
 * @method static Builder<static>|Item claimed()
 * @method static \Database\Factories\ItemFactory factory($count = null, $state = [])
 * @method static Builder<static>|Item gifted()
 * @method static Builder<static>|Item moderating()
 * @method static Builder<static>|Item newModelQuery()
 * @method static Builder<static>|Item newQuery()
 * @method static Builder<static>|Item pending()
 * @method static Builder<static>|Item query()
 * @method static Builder<static>|Item refused()
 * @method static Builder<static>|Item whereCategory($value)
 * @method static Builder<static>|Item whereCity($value)
 * @method static Builder<static>|Item whereCreatedAt($value)
 * @method static Builder<static>|Item whereDescription($value)
 * @method static Builder<static>|Item whereDimensions($value)
 * @method static Builder<static>|Item whereId($value)
 * @method static Builder<static>|Item wherePhotos($value)
 * @method static Builder<static>|Item whereStatus($value)
 * @method static Builder<static>|Item whereTitle($value)
 * @method static Builder<static>|Item whereUpdatedAt($value)
 * @method static Builder<static>|Item whereUserId($value)
 * @method static Builder<static>|Item whereWeight($value)
 *
 * @mixin \Eloquent
 */
class Item extends Model
{
    use HasFactory;

    public const PLACEHOLDER_IMAGE_URL = 'https://via.placeholder.com/400x300/1f2937/9ca3af?text=No+Image';

    protected $fillable = [
        'title',
        'description',
        'category',
        'city',
        'weight',
        'dimensions',
        'photos',
        'status',
        'user_id',
    ];

    protected $casts = [
        'photos' => 'array',
        'status' => ItemStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    /**
     * Scope to filter items by status.
     */
    public function scopeByStatus(Builder $query, ItemStatus $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get only available items.
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->byStatus(ItemStatus::Available);
    }

    /**
     * Scope to get only gifted items.
     */
    public function scopeGifted(Builder $query): Builder
    {
        return $query->byStatus(ItemStatus::Gifted);
    }


    /**
     * Check if item has any photos.
     */
    public function hasPhotos(): bool
    {
        return filled($this->photos);
    }

    /**
     * Get the URL for a photo at the given index.
     */
    public function getPhotoUrl(int $index = 0): ?string
    {
        if (!isset($this->photos[$index]) || blank($this->photos[$index])) {
            return null;
        }

        $photo = $this->photos[$index];

        return $this->isExternalUrl($photo)
            ? $photo
            : Storage::disk('public')->url($photo);
    }

    /**
     * Get the URL for the first photo.
     */
    public function getFirstPhotoUrl(): ?string
    {
        return $this->getPhotoUrl();
    }

    /**
     * Get all photo URLs.
     *
     * @return array<int, string>
     */
    public function getAllPhotoUrls(): array
    {
        if (!$this->hasPhotos()) {
            return [];
        }

        return array_values(array_filter(
            array_map(fn($index) => $this->getPhotoUrl($index), array_keys($this->photos))
        ));
    }

    /**
     * Get the first photo URL or a placeholder if no photo exists.
     */
    public function getFirstPhotoUrlOrPlaceholder(): string
    {
        return $this->getFirstPhotoUrl() ?? self::PLACEHOLDER_IMAGE_URL;
    }

    /**
     * Check if item has a displayable first photo.
     */
    public function hasFirstPhoto(): bool
    {
        return $this->getFirstPhotoUrl() !== null;
    }

    /**
     * Check if the given photo path is an external URL.
     */
    protected function isExternalUrl(string $photo): bool
    {
        return str_starts_with($photo, 'https://');
    }
}
