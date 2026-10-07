<?php

use Illuminate\Support\Facades\Route;

// Every route here starts with /api (added automatically by Laravel).
// Each API version lives in its own file inside routes/api/.
// throttle:api limits every API request (see AppServiceProvider).

Route::prefix('v1')
    ->name('api.v1.')
    ->middleware('throttle:api')
    ->group(base_path('routes/api/v1.php'));

// When v2 is needed:
// Route::prefix('v2')->name('api.v2.')->middleware('throttle:api')->group(base_path('routes/api/v2.php'));
