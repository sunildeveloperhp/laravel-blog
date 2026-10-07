<?php

namespace App\Models;

use App\Notifications\NewCommentOnPost;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    // Only the text can be mass assigned. post_id, user_id and approved_at are set in code.
    protected $fillable = [
        'body',
    ];

    protected function casts(): array
    {
        return [
            'approved_at' => 'datetime',
        ];
    }

    // ---------- Query scopes ----------

    // Comment::approved() -> only approved comments
    public function scopeApproved(Builder $query): void
    {
        $query->whereNotNull('approved_at');
    }

    // Comment::pending() -> only comments waiting for approval
    public function scopePending(Builder $query): void
    {
        $query->whereNull('approved_at');
    }

    // $comment->isApproved() -> true / false
    public function isApproved(): bool
    {
        return $this->approved_at !== null;
    }

    // ---------- Relationships ----------

    // The post this comment is on (also finds posts that are in the trash)
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class)->withTrashed();
    }

    // Who wrote the comment
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function notifyPostAuthor(): void
    {
        $author = $this->post->user;

        if ($author->is($this->user)) {
            return;
        }

        $author->notify(new NewCommentOnPost($this));
    }
}
