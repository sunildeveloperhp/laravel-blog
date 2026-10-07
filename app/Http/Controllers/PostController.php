<?php

namespace App\Http\Controllers;

class PostController extends Controller
{
    // List of all posts
    public function index()
    {
        return 'All posts will be listed here. '
            . '<a href="' . route('posts.show', 'my-first-post') . '">My first post</a> | '
            . '<a href="' . route('posts.create') . '">Write a new post</a>';
    }

    // Form to write a new post
    public function create()
    {
        return 'Form to create a new post';
    }

    // A single post, found by its slug
    public function show($slug)
    {
        return 'Showing post: ' . $slug;
    }
}