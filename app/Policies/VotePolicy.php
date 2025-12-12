<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vote;

class VotePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Vote $vote): bool
    {
        return false;
    }

    /**
     * Determine whether a user can create a vote for an item.
     */
    public function create(User $user, Item $item): bool
    {
        // Cannot vote own item
        if ($item->user_id === $user->id) {
            return false;
        }

        // Cannot vote twice
        return ! $item->votes()->where('user_id', $user->id)->exists();
    }

    /**
     * Allow unvoting only the user's own vote.
     */
    public function delete(User $user, Vote $vote): bool
    {
        return $vote->user_id === $user->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Vote $vote): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Vote $vote): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Vote $vote): bool
    {
        return false;
    }
}
