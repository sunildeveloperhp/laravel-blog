<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    // List of all posts, newest first
    public function index()
    {
        $posts = Post::with(['category', 'user'])
            ->latest('published_at')
            ->get();

        return view('posts.index', ['posts' => $posts]);
    }

    // Form to write a new post
    public function create()
    {
        return view('posts.create');
    }

    // A single post, found by its slug (404 if not found)
 public function show(Post $post)
    {
        $post->load(['category', 'user']);

        return view('posts.show', ['post' => $post]);
    }
}