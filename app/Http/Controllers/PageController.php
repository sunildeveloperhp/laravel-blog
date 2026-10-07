<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    // Home page with the 3 latest posts
    public function home()
    {
        $posts = PostController::dummyPosts()->take(3);

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