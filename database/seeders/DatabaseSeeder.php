<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // A fixed admin account (password: "password"). We'll log in with it later this week.
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => Role::Admin,
        ]);

        // 4 more random authors, plus the admin = 5 authors
        $authors = User::factory(4)->create()->push($admin);

        // Fixed categories and tags
        $this->call([CategorySeeder::class, TagSeeder::class]);
        $categories = Category::all();
        $tags = Tag::all();

        // 30 posts, each with a random author and category
        $posts = Post::factory(30)
            ->recycle($authors)
            ->recycle($categories)
            ->create();

        // Give each post 1 to 3 random tags
        $posts->each(function (Post $post) use ($tags) {
            $post->tags()->attach($tags->random(rand(1, 3)));
        });

        Comment::factory(80)
            ->recycle($posts)
            ->recycle(User::all())
            ->create();
    }
}
