<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TagController extends Controller
{
    // Published posts with one tag, 10 per page
    public function show(Tag $tag)
    {
        $posts = $tag->posts()
            ->with(['category', 'user'])
            ->published()
            ->latest('published_at')
            ->paginate(10);

        return view('tags.show', compact('tag', 'posts'));
    }
}
