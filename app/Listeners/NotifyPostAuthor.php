<?php

namespace App\Listeners;

use App\Events\CommentApproved;

class NotifyPostAuthor
{
    // Tell the post's author (the notification itself goes through the queue)
    public function handle(CommentApproved $event): void
    {
        $event->comment->notifyPostAuthor();
    }
}
