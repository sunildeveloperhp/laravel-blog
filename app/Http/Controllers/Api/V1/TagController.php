<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Models\Tag;

class TagController extends Controller
{
    // GET /api/v1/tags
    public function index()
    {
        $tags = Tag::withCount(['posts' => fn ($query) => $query->published()])
            ->orderBy('name')
            ->get();

        return TagResource::collection($tags);
    }
}
