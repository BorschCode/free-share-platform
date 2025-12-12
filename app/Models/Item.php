<?php

namespace App\Models;

use App\Enums\ItemStatus; // <-- 1. Додайте імпорт вашого Enum
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
 * @mixin \Eloquent
 */
class Item extends Model
{
    use HasFactory;

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

    public function comments(): Builder|HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function votes(): Builder|HasMany
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Scope to filter items by status
     */
    public function scopeByStatus(Builder $query, ItemStatus $status): Builder
    {
        return $query->where('status', $status->value);
    }

    /**
     * Scope to get only available items
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', ItemStatus::Available->value);
    }

    /**
     * Scope to get only gifted items
     */
    public function scopeGifted(Builder $query): Builder
    {
        return $query->where('status', ItemStatus::Gifted->value);
    }

    /**
     * Scope to get only pending items
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', ItemStatus::Pending->value);
    }

    /**
     * Scope to get only moderating items
     */
    public function scopeModerating(Builder $query): Builder
    {
        return $query->where('status', ItemStatus::Moderating->value);
    }

    /**
     * Scope to get only claimed items
     */
    public function scopeClaimed(Builder $query): Builder
    {
        return $query->where('status', ItemStatus::Claimed->value);
    }

    /**
     * Scope to get only refused items
     */
    public function scopeRefused(Builder $query): Builder
    {
        return $query->where('status', ItemStatus::Refused->value);
    }

    /**
     * Check if item has photos
     */
    public function hasPhotos(): bool
    {
        return ! empty($this->photos) && is_array($this->photos) && count($this->photos) > 0;
    }

    /**
     * Get the URL for a photo at the given index
     */
    public function getPhotoUrl(int $index = 0): ?string
    {
        // Check if photos exist and the array is not empty
        if (! $this->hasPhotos() || ! isset($this->photos[$index])) {
            return null;
        }

        $photo = $this->photos[$index];

        // Additional check if photo is empty string or null
        if (empty($photo)) {
            return null;
        }

        // If it's already a full URL, return it directly
        if (str_starts_with($photo, 'http://') || str_starts_with($photo, 'https://')) {
            return $photo;
        }

        // Otherwise, use Storage::url() to generate the URL
        return \Storage::url($photo);
    }

    /**
     * Get the URL for the first photo
     */
    public function getFirstPhotoUrl(): ?string
    {
        return $this->getPhotoUrl(0);
    }

    /**
     * Get all photo URLs
     *
     * @return array<int, string>
     */
    public function getAllPhotoUrls(): array
    {
        if (! $this->hasPhotos()) {
            return [];
        }

        $urls = [];
        foreach ($this->photos as $index => $photo) {
            $url = $this->getPhotoUrl($index);
            if ($url !== null) {
                $urls[] = $url;
            }
        }

        return $urls;
    }

    /**
     * Get the first photo URL or a placeholder if no photo exists
     */
    public function getFirstPhotoUrlOrPlaceholder(): string
    {
        $url = $this->getFirstPhotoUrl();

        if ($url !== null) {
            return $url;
        }

        // Return a placeholder image URL
        return 'https://via.placeholder.com/400x300/1f2937/9ca3af?text=No+Image';
    }

    /**
     * Check if item has a displayable first photo
     */
    public function hasFirstPhoto(): bool
    {
        return $this->getFirstPhotoUrl() !== null;
    }
}
