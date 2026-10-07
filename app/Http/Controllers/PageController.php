<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    // Home page. Later it will show the latest posts.
    public function home()
    {
        return 'Home page — latest posts will appear here. '
            . '<a href="' . route('posts.index') . '">All posts</a> | '
            . '<a href="' . route('about') . '">About</a> | '
            . '<a href="' . route('contact') . '">Contact</a>';
    }

    public function about()
    {
        return 'About this blog';
    }

    public function contact()
    {
        return 'Contact page — a contact form will go here';
    }
}