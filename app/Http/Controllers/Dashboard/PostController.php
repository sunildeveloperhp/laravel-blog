<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    // Only the logged-in user's own posts
    public function index(Request $request)
    {
        $posts = $request->user()
            ->posts()
            ->with('category')
            ->latest('published_at')
            ->paginate(15);

        return view('dashboard.posts.index', ['posts' => $posts]);
    }

    // Show the empty "new post" form
    public function create()
    {
        Gate::authorize('create', Post::class);

        return view('dashboard.posts.create', [
            'post' => new Post,
            'categories' => Category::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }

    // Save the new post (PostRequest already checked permission and validated the data)
    public function store(PostRequest $request, PostService $posts)
    {
        $post = $posts->create(
            $request->user(),
            $request->safe()->except(['tags', 'featured_image', 'remove_image']),
            $request->file('featured_image'),
            $request->validated('tags', []),
        );

        return redirect()
            ->route('dashboard.posts.index')
            ->with('success', 'Post "'.$post->title.'" was published.');
    }

    // Show the form filled with an existing post (owner only)
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);

        return view('dashboard.posts.edit', [
            'post' => $post,
            'categories' => Category::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }

    // Save the changes (PostRequest already checked permission and validated the data)
    public function update(PostRequest $request, Post $post, PostService $posts)
    {
        $posts->update(
            $post,
            $request->safe()->except(['tags', 'featured_image', 'remove_image']),
            $request->file('featured_image'),
            $request->boolean('remove_image'),
            $request->validated('tags', []),   // the form sends no "tags" when all boxes are unticked = remove all
        );

        return redirect()
            ->route('dashboard.posts.index')
            ->with('success', 'Post "'.$post->title.'" was updated.');
    }

    // Soft delete the post (owner only)
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return back()->with('success', 'Post "'.$post->title.'" was moved to trash.');
    }
}
