<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewCommentOnPost extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Comment $comment) {}

    // Where to deliver it: by email AND into the database (for the bell)
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    // The email
    public function toMail(object $notifiable): MailMessage
    {
        $post = $this->comment->post;

        return (new MailMessage)
            ->subject('New comment on "'.$post->title.'"')
            ->greeting('Hi '.$notifiable->name.',')
            ->line($this->comment->user->name.' commented on your post "'.$post->title.'":')
            ->line('"'.Str::limit($this->comment->body, 200).'"')
            ->action('Read the comment', route('posts.show', $post).'#comments')
            ->line('Thanks for writing on '.config('app.name').'!');
    }

    // What gets saved in the notifications table (for the bell)
    public function toArray(object $notifiable): array
    {
        return [
            'commenter_name' => $this->comment->user->name,
            'post_title' => $this->comment->post->title,
            'post_url' => route('posts.show', $this->comment->post).'#comments',
            'excerpt' => Str::limit($this->comment->body, 100),
        ];
    }
}
