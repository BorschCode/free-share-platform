<?php

namespace App\Models;

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
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vote> $votes
 * @property-read int|null $votes_count
 * @method static \Database\Factories\ItemFactory factory($count = null, $state = [])
 * @method static Builder<static>|Item newModelQuery()
 * @method static Builder<static>|Item newQuery()
 * @method static Builder<static>|Item query()
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
        'photos' => 'array', // Automatically cast JSON to array
    ];

    // Item belongs to a user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Optional: comments relation
    public function comments(): Builder|HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // Optional: votes relation
    public function votes(): Builder|HasMany
    {
        return $this->hasMany(Vote::class);
    }
}
