<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_shows_the_latest_published_posts(): void
    {
        Post::factory()->create(['title' => 'Hello Testing World']);

        $this->get('/')
            ->assertOk()
            ->assertSee('Hello Testing World');
    }

    public function test_a_published_post_can_be_viewed(): void
    {
        $post = Post::factory()->create();

        $this->get(route('posts.show', $post))
            ->assertOk()
            ->assertSee($post->title);
    }

    public function test_guests_cannot_see_draft_posts(): void
    {
        $post = Post::factory()->create(['published_at' => null]);

        $this->get(route('posts.show', $post))->assertNotFound();
    }

    public function test_authors_can_preview_their_own_drafts(): void
    {
        $post = Post::factory()->create(['published_at' => null]);

        $this->actingAs($post->user)
            ->get(route('posts.show', $post))
            ->assertOk();
    }
}
