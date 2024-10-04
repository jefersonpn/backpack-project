<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
    'as' => 'admin.',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController'); // Existing route

    // Custom route for the dashboard
    Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
});

/**
 * DO NOT ADD ANYTHING BELOW THIS LINE.
 */
