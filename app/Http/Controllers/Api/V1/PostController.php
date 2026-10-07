<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    // GET /api/v1/posts?q=...&category=...&page=...
    public function index(Request $request)
    {
        $posts = Post::with(['category', 'user', 'tags'])
            ->withCount(['comments' => fn ($query) => $query->approved()])
            ->published()
            ->search($request->query('q'))
            ->inCategory($request->query('category'))
            ->latest('published_at')
            ->paginate(10)
            ->withQueryString();

        return PostResource::collection($posts);
    }

    // GET /api/v1/posts/{slug}
    public function show(Post $post)
    {
        // Drafts and scheduled posts are not public
        abort_unless($post->published_at?->isPast(), 404);

        $post->load(['category', 'user', 'tags'])
            ->loadCount(['comments' => fn ($query) => $query->approved()]);

        return new PostResource($post);
    }

    // POST /api/v1/posts
    public function store(PostRequest $request, PostService $posts)
    {
        $post = $posts->create(
            $request->user(),
            $request->safe()->except(['tags', 'featured_image', 'remove_image']),
            $request->file('featured_image'),
            $request->validated('tags', []),
        );

        $post->load(['category', 'user', 'tags']);

        return (new PostResource($post))
            ->response()
            ->setStatusCode(201);
    }

    // PUT /api/v1/posts/{slug}
    public function update(PostRequest $request, Post $post, PostService $posts)
    {
        $posts->update(
            $post,
            $request->safe()->except(['tags', 'featured_image', 'remove_image']),
            $request->file('featured_image'),
            $request->boolean('remove_image'),
            $request->has('tags') ? $request->validated('tags', []) : null,   // no "tags" sent = keep the current tags
        );

        $post->load(['category', 'user', 'tags']);

        return new PostResource($post);
    }

    // DELETE /api/v1/posts/{slug}
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return response()->noContent();
    }
}
