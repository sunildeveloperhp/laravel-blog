<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardPostsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_sent_to_the_login_page(): void
    {
        $this->get(route('dashboard.posts.index'))
            ->assertRedirect(route('login'));
    }

    public function test_an_author_can_create_a_post(): void
    {
        $author = User::factory()->create();
        $category = Category::factory()->create();

        $this->actingAs($author)
            ->post(route('dashboard.posts.store'), [
                'title' => 'My tested post',
                'category_id' => $category->id,
                'excerpt' => 'A short excerpt for the test.',
                'body' => 'This body is long enough to pass the validation rules.',
            ])
            ->assertRedirect(route('dashboard.posts.index'));

        $this->assertDatabaseHas('posts', [
            'title' => 'My tested post',
            'slug' => 'my-tested-post',
            'user_id' => $author->id,
        ]);
    }

    public function test_an_empty_post_shows_validation_errors(): void
    {
        $author = User::factory()->create();

        $this->actingAs($author)
            ->post(route('dashboard.posts.store'), [])
            ->assertSessionHasErrors(['title', 'category_id', 'excerpt', 'body']);
    }

    public function test_an_author_cannot_edit_or_delete_someone_elses_post(): void
    {
        $post = Post::factory()->create();
        $otherAuthor = User::factory()->create();

        $this->actingAs($otherAuthor)
            ->get(route('dashboard.posts.edit', $post))
            ->assertForbidden();

        $this->actingAs($otherAuthor)
            ->delete(route('dashboard.posts.destroy', $post))
            ->assertForbidden();

        $this->assertNotSoftDeleted($post);
    }

    public function test_an_admin_can_edit_any_post(): void
    {
        $post = Post::factory()->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('dashboard.posts.edit', $post))
            ->assertOk();
    }

    public function test_readers_cannot_write_posts(): void
    {
        $reader = User::factory()->reader()->create();

        $this->actingAs($reader)
            ->get(route('dashboard.posts.create'))
            ->assertForbidden();
    }
}
