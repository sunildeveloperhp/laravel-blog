<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Support\BlogCache;

class TagController extends Controller
{
    // GET /api/v1/tags (cached)
    public function index()
    {
        return TagResource::collection(BlogCache::tags());
    }
}
