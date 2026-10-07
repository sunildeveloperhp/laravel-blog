<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{

    public function show(Category $category)
    {
        $posts = $category->posts()
            ->with(['category', 'user'])
            ->latest('published_at')
            ->get();

        return view('categories.show', compact('category', 'posts'));
    }

}