<?php

namespace App\Http\Controllers;

use App\Models\User;

class AuthorController extends Controller
{
    // All published posts by one author
    public function show(User $user)
    {
        $posts = $user->posts()
            ->with(['category', 'user'])
            ->published()
            ->latest('published_at')
            ->paginate(10);

        return view('authors.show', compact('user', 'posts'));
    }
}
