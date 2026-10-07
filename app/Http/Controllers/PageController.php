<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PageController extends Controller
{
    // Home page with the 3 latest posts
    public function home()
    {
        $posts = Post::with(['category', 'user'])
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('pages.home', ['posts' => $posts]);
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }
}