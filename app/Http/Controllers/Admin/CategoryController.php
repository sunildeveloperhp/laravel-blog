<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    // All categories with their post counts
    public function index()
    {
        $categories = Category::withCount('posts')
            ->orderBy('name')
            ->get();

        return view('admin.categories.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('admin.categories.create', ['category' => new Category]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:categories,name'],
        ]);

        $slug = Str::slug($data['name']);

        // "Web Dev" and "web-dev" are different names but would give the same slug
        if (Category::where('slug', $slug)->exists()) {
            return back()
                ->withErrors(['name' => 'A category with a very similar name already exists.'])
                ->withInput();
        }

        $category = Category::create([
            'name' => $data['name'],
            'slug' => $slug,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category "'.$category->name.'" was created.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', ['category' => $category]);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50', Rule::unique('categories', 'name')->ignore($category->id)],
        ]);

        // Only the name changes. The slug stays the same, so old category URLs keep working.
        $category->update(['name' => $data['name']]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category renamed to "'.$category->name.'".');
    }

    public function destroy(Category $category)
    {
        // Posts point to their category, so a category that still has posts can't be removed
        if ($category->posts()->withTrashed()->exists()) {
            return back()->with('error', 'Category "'.$category->name.'" still has posts. Move them to another category first.');
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category "'.$category->name.'" was deleted.');
    }
}
