<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Anyone authenticated may create a comment.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Users may update only their own comments.
     */
    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Users may delete only their own comments.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Anyone may view comments.
     */
    public function view(User $user, Comment $comment): bool
    {
        return true;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }
}
