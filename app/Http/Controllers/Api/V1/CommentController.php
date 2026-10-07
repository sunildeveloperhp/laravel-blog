<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Post;
use App\Services\CommentService;

class CommentController extends Controller
{
    // GET /api/v1/posts/{slug}/comments -> approved comments, oldest first
    public function index(Post $post)
    {
        abort_unless($post->published_at?->isPast(), 404);

        $comments = $post->comments()
            ->approved()
            ->with('user')
            ->oldest()
            ->paginate(20);

        return CommentResource::collection($comments);
    }

    // POST /api/v1/posts/{slug}/comments
    public function store(StoreCommentRequest $request, Post $post, CommentService $comments)
    {
        abort_unless($post->published_at?->isPast(), 404);

        $comment = $comments->create($post, $request->user(), $request->validated('body'));
        $comment->load('user');

        return (new CommentResource($comment))
            ->additional([
                'message' => $comment->isApproved()
                    ? 'Your comment was posted.'
                    : 'Your comment will appear after an admin approves it.',
            ])
            ->response()
            ->setStatusCode(201);
    }
}
