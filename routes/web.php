<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;


Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
});

// Posts
Route::controller(PostController::class)
    ->prefix('posts')
    ->name('posts.')
    ->group(function () {
        Route::get('/', 'index')->name('index');            // /posts
        Route::get('/create', 'create')->name('create');    // /posts/create
        Route::get('/{slug}', 'show')
            ->where('slug', '[a-z0-9-]+')
            ->name('show');                                  // /posts/my-first-post
    });

// Categories
Route::get('/categories/{slug}', [CategoryController::class, 'show'])
    ->where('slug', '[a-z0-9-]+')
    ->name('categories.show'); 
