<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;

class MyPostController extends Controller
{
    // GET /api/v1/my/posts -> the logged-in user's own posts, including drafts
    public function index(Request $request)
    {
        $posts = $request->user()
            ->posts()
            ->with(['category', 'tags'])
            ->latest('published_at')
            ->paginate(10);

        return PostResource::collection($posts);
    }
}
