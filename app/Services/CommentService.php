<?php

namespace App\Services;

use App\Events\CommentApproved;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentService
{
    // Save a comment. Admin comments are approved straight away.
    public function create(Post $post, User $author, string $body): Comment
    {
        $comment = new Comment(['body' => $body]);
        $comment->user()->associate($author);

        if ($author->isAdmin()) {
            $comment->approved_at = now();
        }

        $post->comments()->save($comment);

        if ($comment->isApproved()) {
            CommentApproved::dispatch($comment);
        }

        return $comment;
    }
}
