<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // All posts in one category
    public function show($slug)
    {
        $posts = PostController::dummyPosts()->where('category_slug', $slug);
        $categoryName = Str::headline($slug);   // "web-development" becomes "Web Development"

        return view('categories.show', compact('posts', 'categoryName'));
    }
}