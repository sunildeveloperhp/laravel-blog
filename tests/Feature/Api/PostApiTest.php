<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PostApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_posts_list_is_paginated_and_hides_private_author_data(): void
    {
        Post::factory()->count(3)->create();

        $this->getJson('/api/v1/posts')
            ->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [['id', 'title', 'slug', 'author' => ['id', 'name']]],
                'links',
                'meta',
            ])
            ->assertJsonMissingPath('data.0.author.email');
    }

    public function test_creating_a_post_needs_a_token(): void
    {
        $this->postJson('/api/v1/posts', [])->assertUnauthorized();
    }

    public function test_an_author_can_create_a_post_with_a_token(): void
    {
        $author = User::factory()->create();
        $category = Category::factory()->create();

        Sanctum::actingAs($author);

        $this->postJson('/api/v1/posts', [
            'title' => 'Created from a test',
            'category_id' => $category->id,
            'excerpt' => 'This post was created by an automated test.',
            'body' => 'The API should accept this post and return it as JSON.',
        ])
            ->assertCreated()
            ->assertJsonPath('data.title', 'Created from a test')
            ->assertJsonPath('data.author.id', $author->id);
    }

    public function test_validation_errors_come_back_as_422_json(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $this->postJson('/api/v1/posts', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['title', 'category_id', 'excerpt', 'body']);
    }

    public function test_an_author_cannot_update_someone_elses_post(): void
    {
        $post = Post::factory()->create();
        $category = Category::factory()->create();

        Sanctum::actingAs(User::factory()->create());

        $this->putJson('/api/v1/posts/'.$post->slug, [
            'title' => 'Trying to change it',
            'category_id' => $category->id,
            'excerpt' => 'This should not be allowed.',
            'body' => 'Only the owner or an admin may update this post.',
        ])->assertForbidden();
    }

    public function test_a_missing_post_returns_a_clean_404(): void
    {
        $this->getJson('/api/v1/posts/does-not-exist')
            ->assertNotFound()
            ->assertExactJson(['message' => 'Post not found.']);
    }
}
