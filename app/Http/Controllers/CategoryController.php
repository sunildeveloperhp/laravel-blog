<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    // Published posts in one category, 10 per page
    public function show(Category $category)
    {
        $posts = $category->posts()
            ->with(['category', 'user'])
            ->published()
            ->latest('published_at')
            ->paginate(10);

        return view('categories.show', compact('category', 'posts'));
    }
}