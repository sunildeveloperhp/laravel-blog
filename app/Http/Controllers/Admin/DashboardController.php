<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

class DashboardController extends Controller
{
    // Overview: counts and newest users
    public function index()
    {
        return view('admin.dashboard', [
            'stats' => [
                'Posts' => Post::count(),
                'Users' => User::count(),
                'Pending comments' => Comment::pending()->count(),
                'Categories' => Category::count(),
                'Tags' => Tag::count(),
            ],
            'latestUsers' => User::latest()->take(5)->get(),
        ]);
    }
}
