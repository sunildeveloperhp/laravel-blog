<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // Table of all posts with Edit / Delete buttons
    public function index()
    {
        $posts = Post::with('category')
            ->latest('published_at')
            ->paginate(15);

        return view('dashboard.posts.index', ['posts' => $posts]);
    }

    // Show the empty "new post" form
    public function create()
    {
        return view('dashboard.posts.create', [
            'post' => new Post(),
            'categories' => Category::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }

    // Save the new post, its image and its tags
    public function store(PostRequest $request)
    {
        $data = $request->safe()->except(['tags', 'featured_image', 'remove_image']);
        $data['user_id'] = User::first()->id;   // TEMPORARY: replaced by the logged-in user on Day 4
        $data['published_at'] = now();

        if ($request->hasFile('featured_image')) {
            // Saves to storage/app/public/posts/<random-name>.jpg and returns "posts/<random-name>.jpg"
            $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        $post = Post::create($data);
        $post->tags()->sync($request->validated('tags', []));

        return redirect()
            ->route('dashboard.posts.index')
            ->with('success', 'Post "' . $post->title . '" was published.');
    }

    // Show the form filled with an existing post
    public function edit(Post $post)
    {
        return view('dashboard.posts.edit', [
            'post' => $post,
            'categories' => Category::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }

    // Save the changes, including a new / removed image and tags
    public function update(PostRequest $request, Post $post)
    {
        $data = $request->safe()->except(['tags', 'featured_image', 'remove_image']);

        if ($request->hasFile('featured_image')) {
            // A new image was uploaded: delete the old file, then save the new one
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        } elseif ($request->boolean('remove_image') && $post->featured_image) {
            // "Remove current image" was ticked: delete the file and clear the column
            Storage::disk('public')->delete($post->featured_image);
            $data['featured_image'] = null;
        }

        $post->update($data);
        $post->tags()->sync($request->validated('tags', []));

        return redirect()
            ->route('dashboard.posts.index')
            ->with('success', 'Post "' . $post->title . '" was updated.');
    }

    // Soft delete the post (the image file is kept, so the post can be restored with its image)
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()
            ->route('dashboard.posts.index')
            ->with('success', 'Post "' . $post->title . '" was moved to trash.');
    }
}