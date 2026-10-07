<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    // All posts in one category (404 if the category doesn't exist)
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = $category->posts()
            ->with(['category', 'user'])
            ->latest('published_at')
            ->get();

        return view('categories.show', compact('category', 'posts'));
    }
}