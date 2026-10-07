<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Support\BlogCache;

class CategoryController extends Controller
{
    // GET /api/v1/categories (cached)
    public function index()
    {
        return CategoryResource::collection(BlogCache::categories());
    }
}
