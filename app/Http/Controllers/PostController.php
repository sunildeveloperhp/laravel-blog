<?php

namespace App\Http\Controllers;

class PostController extends Controller
{
     public static function dummyPosts()
    {
        return collect([
            (object) [
                'title' => 'Getting Started with Laravel',
                'slug' => 'getting-started-with-laravel',
                'excerpt' => 'Install Laravel, understand the folder structure, and run your first app.',
                'body' => "Laravel is a PHP framework that gives you routing, a database layer, templating and much more out of the box.\n\nIn this post we install a fresh project with Composer, look at the most important folders, and run the app in the browser.",
                'category_name' => 'Laravel',
                'category_slug' => 'laravel',
                'author' => 'Admin',
                'published_at' => '5 Oct 2026',
            ],
            (object) [
                'title' => 'Understanding Laravel Routing',
                'slug' => 'understanding-laravel-routing',
                'excerpt' => 'Routes, parameters, named routes and route groups explained simply.',
                'body' => "Every URL in a Laravel app is defined in a routes file.\n\nThis post covers route parameters, constraints, named routes, and how route groups keep your routes file clean.",
                'category_name' => 'Laravel',
                'category_slug' => 'laravel',
                'author' => 'Admin',
                'published_at' => '6 Oct 2026',
            ],
            (object) [
                'title' => 'PHP Arrays Explained',
                'slug' => 'php-arrays-explained',
                'excerpt' => 'Indexed arrays, associative arrays, and the functions you will use every day.',
                'body' => "Arrays are everywhere in PHP.\n\nWe look at indexed and associative arrays, how to loop over them, and useful functions like array_map and array_filter.",
                'category_name' => 'PHP',
                'category_slug' => 'php',
                'author' => 'Admin',
                'published_at' => '7 Oct 2026',
            ],
            (object) [
                'title' => 'Why Every Website Needs SSL',
                'slug' => 'why-every-website-needs-ssl',
                'excerpt' => 'What HTTPS does, why browsers warn without it, and how it affects SEO.',
                'body' => "SSL encrypts the connection between the visitor and your server.\n\nWithout it, browsers show a 'Not secure' warning and search engines rank the site lower.",
                'category_name' => 'Web Development',
                'category_slug' => 'web-development',
                'author' => 'Admin',
                'published_at' => '8 Oct 2026',
            ],
        ]);
    }

    // List of all posts
    public function index()
    {
        $posts = self::dummyPosts();

        return view('posts.index', ['posts' => $posts]);
    }

    // Form to write a new post
    public function create()
    {
        return view('posts.create');
    }

    // A single post, found by its slug
    public function show($slug)
    {
        $post = self::dummyPosts()->firstWhere('slug', $slug);

        if (! $post) {
            abort(404);
        }

        return view('posts.show', ['post' => $post]);
    }
}