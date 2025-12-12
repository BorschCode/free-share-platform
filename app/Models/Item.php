<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Optional: comments relation
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Optional: votes relation
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
