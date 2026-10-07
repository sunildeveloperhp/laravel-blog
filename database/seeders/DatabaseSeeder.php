<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // A fixed admin account (password: "password"). We'll log in with it in Week 2.
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        // 4 more random authors, plus the admin = 5 authors
        $authors = User::factory(4)->create()->push($admin);

        // The 5 fixed categories
        $this->call(CategorySeeder::class);
        $categories = Category::all();

        // 30 posts, each one gets a random author and category from the lists above
        Post::factory(30)
            ->recycle($authors)
            ->recycle($categories)
            ->create();
    }
}