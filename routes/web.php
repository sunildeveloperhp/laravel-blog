<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Dashboard\PostController as DashboardPostController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

// Static pages
Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
});

// Public posts (read only)
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');

// Categories and tags
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/tags/{tag:slug}', [TagController::class, 'show'])->name('tags.show');

// Dashboard (login protection gets added on Day 4 of this week)
Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::resource('posts', DashboardPostController::class)->except('show');
});