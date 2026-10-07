<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Support\BlogCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // List of posts with search, category filter and pagination
    public function index(Request $request)
    {
        $posts = Post::with(['category', 'user'])
            ->published()
            ->search($request->query('q'))
            ->inCategory($request->query('category'))
            ->latest('published_at')
            ->paginate(10)
            ->withQueryString();

        return view('posts.index', [
            'posts' => $posts,
            'categories' => BlogCache::categories(),
        ]);
    }

    // A single post with its category, author, tags and comments
    public function show(Request $request, Post $post)
    {

        $isPublished = $post->published_at?->isPast() ?? false;
        abort_unless($isPublished || $request->user()?->can('update', $post), 404);

        $post->load(['category', 'user', 'tags']);

        // Everyone sees approved comments. A logged-in user also sees their own pending ones.
        $comments = $post->comments()
            ->with('user')
            ->where(function (Builder $query) use ($request) {
                $query->approved();

                if ($request->user()) {
                    $query->orWhere('user_id', $request->user()->id);
                }
            })
            ->oldest()
            ->get();

        return view('posts.show', [
            'post' => $post,
            'comments' => $comments,
        ]);
    }
}
