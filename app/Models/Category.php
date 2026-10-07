<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    // Columns that are allowed to be filled with create() / update()
    protected $fillable = [
        'name',
        'slug',
    ];

    // A category has many posts
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}