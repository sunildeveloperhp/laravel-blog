<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Post;
use App\Services\CommentService;

class CommentController extends Controller
{
    // Save a new comment on a post (website form)
    public function store(StoreCommentRequest $request, Post $post, CommentService $comments)
    {
        $comment = $comments->create($post, $request->user(), $request->validated('body'));

        $message = $comment->isApproved()
            ? 'Your comment was posted.'
            : 'Thanks! Your comment will appear after an admin approves it.';

        return redirect()
            ->to(route('posts.show', $post).'#comments')
            ->with('comment_status', $message);
    }
}
