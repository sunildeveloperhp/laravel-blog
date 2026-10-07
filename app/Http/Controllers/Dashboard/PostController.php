<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

class PostController extends Controller
{
    // Table of all posts with Edit / Delete buttons
    public function index()
    {
        $posts = Post::with('category')
            ->latest('published_at')
            ->get();

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

    // Save the new post and its tags
    public function store(PostRequest $request)
    {
        $data = $request->safe()->except('tags');   // everything except tags goes into the posts table
        $data['user_id'] = User::first()->id;       // TEMPORARY: replaced by the logged-in user on Day 4
        $data['published_at'] = now();

        $post = Post::create($data);
        $post->tags()->sync($request->validated('tags', []));   // tags go into the post_tag table

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

    // Save the changes, including tags
    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->safe()->except('tags'));
        $post->tags()->sync($request->validated('tags', []));

        return redirect()
            ->route('dashboard.posts.index')
            ->with('success', 'Post "' . $post->title . '" was updated.');
    }

    // Soft delete the post
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()
            ->route('dashboard.posts.index')
            ->with('success', 'Post "' . $post->title . '" was moved to trash.');
    }
}