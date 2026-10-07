<?php

namespace App\Support;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class BlogCache
{
    // Cache keys, written in one place so a typo can't leave stale data behind
    public const HOME_POSTS = 'blog.home_posts';

    public const CATEGORIES = 'blog.categories';

    public const TAGS = 'blog.tags';

    // Keep cached data for 10 minutes at most, even if nothing clears it
    public const TTL = 600;

    // The 3 newest published posts for the home page
    public static function homePosts(): Collection
    {
        return Cache::remember(self::HOME_POSTS, self::TTL, function () {
            return Post::with(['category', 'user'])
                ->published()
                ->latest('published_at')
                ->take(3)
                ->get();
        });
    }

    // All categories with their number of published posts
    public static function categories(): Collection
    {
        return Cache::remember(self::CATEGORIES, self::TTL, function () {
            return Category::withCount(['posts' => fn ($query) => $query->published()])
                ->orderBy('name')
                ->get();
        });
    }

    // All tags with their number of published posts
    public static function tags(): Collection
    {
        return Cache::remember(self::TAGS, self::TTL, function () {
            return Tag::withCount(['posts' => fn ($query) => $query->published()])
                ->orderBy('name')
                ->get();
        });
    }

    // Forget everything above. Called whenever posts, categories or tags change.
    public static function flush(): void
    {
        Cache::forget(self::HOME_POSTS);
        Cache::forget(self::CATEGORIES);
        Cache::forget(self::TAGS);
    }
}
