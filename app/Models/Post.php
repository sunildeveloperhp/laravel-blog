<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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