<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewCommentOnPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_new_comment_waits_for_approval(): void
    {
        $post = Post::factory()->create();

        $this->actingAs(User::factory()->create())
            ->post(route('comments.store', $post), ['body' => 'Nice post!'])
            ->assertRedirect();

        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'body' => 'Nice post!',
            'approved_at' => null,
        ]);
    }

    public function test_comments_on_draft_posts_are_rejected(): void
    {
        $post = Post::factory()->create(['published_at' => null]);

        $this->actingAs(User::factory()->create())
            ->post(route('comments.store', $post), ['body' => 'Hello there!'])
            ->assertNotFound();

        $this->assertDatabaseCount('comments', 0);
    }

    public function test_approving_a_comment_notifies_the_post_author(): void
    {
        Notification::fake();

        $comment = Comment::factory()->create(['approved_at' => null]);
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->patch(route('admin.comments.approve', $comment))
            ->assertRedirect();

        $this->assertNotNull($comment->fresh()->approved_at);
        Notification::assertSentTo($comment->post->user, NewCommentOnPost::class);
    }
}
