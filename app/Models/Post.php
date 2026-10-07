<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    // Columns that are allowed to be filled with create() / update()
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'featured_image',
        'published_at',
    ];

    // Turn published_at into a date object, so we can call ->format() on it
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    // Runs automatically: before a new post is saved, give it a unique slug
    protected static function booted(): void
    {
        static::creating(function (Post $post) {
            if (empty($post->slug)) {
                $post->slug = static::uniqueSlug($post->title);
            }
        });
    }

    // "Hello World" -> "hello-world", or "hello-world-2" if that's taken
    public static function uniqueSlug(string $title): string
    {
        $slug = Str::slug($title);

        if ($slug === '') {
            $slug = 'post';
        }

        $original = $slug;
        $count = 2;

        while (static::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $original . '-' . $count;
            $count++;
        }

        return $slug;
    }

    // ---------- Accessors ----------

    // $post->featured_image_url -> full URL of the image, or null if the post has no image
    protected function featuredImageUrl(): Attribute
    {
        return Attribute::get(function () {
            if (! $this->featured_image) {
                return null;
            }

            return Storage::disk('public')->url($this->featured_image);
        });
    }

    // ---------- Query scopes ----------

    // Post::published() -> only posts that have a publish date that isn't in the future
    public function scopePublished(Builder $query): void
    {
        $query->whereNotNull('published_at')
              ->where('published_at', '<=', now());
    }

    // Post::search('laravel') -> title or excerpt contains the word. Does nothing if the term is empty.
    public function scopeSearch(Builder $query, ?string $term): void
    {
        if (blank($term)) {
            return;
        }

        $query->where(function (Builder $q) use ($term) {
            $q->where('title', 'like', '%' . $term . '%')
              ->orWhere('excerpt', 'like', '%' . $term . '%');
        });
    }

    // Post::inCategory('php') -> only posts in that category. Does nothing if the slug is empty.
    public function scopeInCategory(Builder $query, ?string $slug): void
    {
        if (blank($slug)) {
            return;
        }

        $query->whereHas('category', function (Builder $q) use ($slug) {
            $q->where('slug', $slug);
        });
    }

    // ---------- Relationships ----------

    // A post belongs to one author
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // A post belongs to one category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // A post has many tags (through the post_tag pivot table)
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}