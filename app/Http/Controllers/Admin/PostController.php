<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Every post from every author, with search
    public function index(Request $request)
    {
        $posts = Post::with(['user', 'category'])
            ->search($request->query('q'))
            ->latest('published_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.posts.index', ['posts' => $posts]);
    }
}
