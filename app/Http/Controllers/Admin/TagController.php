<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    // All tags with their post counts
    public function index()
    {
        $tags = Tag::withCount('posts')
            ->orderBy('name')
            ->get();

        return view('admin.tags.index', ['tags' => $tags]);
    }

    public function create()
    {
        return view('admin.tags.create', ['tag' => new Tag]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:30', 'unique:tags,name'],
        ]);

        $slug = Str::slug($data['name']);

        // "Best Practices" and "best-practices" are different names but would give the same slug
        if (Tag::where('slug', $slug)->exists()) {
            return back()
                ->withErrors(['name' => 'A tag with a very similar name already exists.'])
                ->withInput();
        }

        $tag = Tag::create([
            'name' => $data['name'],
            'slug' => $slug,
        ]);

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag "'.$tag->name.'" was created.');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', ['tag' => $tag]);
    }

    public function update(Request $request, Tag $tag)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:30', Rule::unique('tags', 'name')->ignore($tag->id)],
        ]);

        // Only the name changes. The slug stays the same, so old tag URLs keep working.
        $tag->update(['name' => $data['name']]);

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag renamed to "'.$tag->name.'".');
    }

    public function destroy(Tag $tag)
    {
        // No "still has posts" check here: the post_tag rows are removed automatically
        // (cascadeOnDelete in the pivot migration), and the posts themselves stay.
        $postCount = $tag->posts()->count();

        $tag->delete();

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag "'.$tag->name.'" was deleted and removed from '.$postCount.' '.Str::plural('post', $postCount).'.');
    }
}
