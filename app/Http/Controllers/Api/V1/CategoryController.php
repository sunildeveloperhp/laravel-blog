<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    // GET /api/v1/categories
    public function index()
    {
        $categories = Category::withCount(['posts' => fn ($query) => $query->published()])
            ->orderBy('name')
            ->get();

        return CategoryResource::collection($categories);
    }
}
