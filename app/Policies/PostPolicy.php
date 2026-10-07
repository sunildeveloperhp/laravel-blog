<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    // Runs BEFORE every other check in this policy
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;    // admins can do everything
        }

        return null;        // not an admin: continue to the normal check below
    }

    // Can this user write new posts? Authors can, readers can't.
    public function create(User $user): bool
    {
        return $user->canWritePosts();
    }

    // Can this user edit this post? Only its author (or an admin, via before()).
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    // Can this user delete this post? Only its author (or an admin, via before()).
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
}
