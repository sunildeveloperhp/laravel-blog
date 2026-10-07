<?php

use App\Http\Controllers\Api\V1;
use Illuminate\Support\Facades\Route;

// Version 1 of the API. These URLs start with /api/v1 and route names with "api.v1."
// (the prefix, name and the general "api" rate limit are added in routes/api.php).

// GET /api/v1  ->  basic info about the API
Route::get('/', function () {
    return response()->json([
        'name' => config('app.name').' API',
        'version' => 'v1',
    ]);
})->name('info');

// Public, read-only endpoints
Route::get('/posts', [V1\PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post:slug}', [V1\PostController::class, 'show'])->name('posts.show');
Route::get('/posts/{post:slug}/comments', [V1\CommentController::class, 'index'])->name('posts.comments.index');
Route::get('/categories', [V1\CategoryController::class, 'index'])->name('categories.index');
Route::get('/tags', [V1\TagController::class, 'index'])->name('tags.index');

// Get a token (stricter "login" limit on top of the general one)
Route::post('/register', [V1\AuthController::class, 'register'])->middleware('throttle:login')->name('register');
Route::post('/login', [V1\AuthController::class, 'login'])->middleware('throttle:login')->name('login');

// Endpoints that need a valid token
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [V1\AuthController::class, 'logout'])->name('logout');
    Route::get('/user', [V1\AuthController::class, 'me'])->name('user');

    // Writing needs a verified email, same as the website
    Route::middleware('verified')->group(function () {
        Route::get('/my/posts', [V1\MyPostController::class, 'index'])->name('my-posts.index');

        Route::post('/posts', [V1\PostController::class, 'store'])->name('posts.store');
        Route::put('/posts/{post:slug}', [V1\PostController::class, 'update'])->name('posts.update');
        Route::delete('/posts/{post:slug}', [V1\PostController::class, 'destroy'])->name('posts.destroy');

        Route::post('/posts/{post:slug}/comments', [V1\CommentController::class, 'store'])
            ->middleware('throttle:comments')
            ->name('posts.comments.store');
    });
});
