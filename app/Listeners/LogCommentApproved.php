<?php

namespace App\Listeners;

use App\Events\CommentApproved;
use Illuminate\Support\Facades\Log;

class LogCommentApproved
{
    // Keep a record in storage/logs/laravel.log
    public function handle(CommentApproved $event): void
    {
        Log::info('Comment approved', [
            'comment_id' => $event->comment->id,
            'post_id' => $event->comment->post_id,
            'user_id' => $event->comment->user_id,
        ]);
    }
}
