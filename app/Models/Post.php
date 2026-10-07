<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
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

        // Titles with no English letters or numbers (e.g. only symbols) give an empty slug
        if ($slug === '') {
            $slug = 'post';
        }

        $original = $slug;
        $count = 2;

        // withTrashed() also checks soft-deleted posts, because their slugs still exist in the table
        while (static::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $original . '-' . $count;
            $count++;
        }

        return $slug;
    }

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
}