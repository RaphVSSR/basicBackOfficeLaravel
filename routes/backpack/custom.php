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
], function () { // custom admin routes
    Route::crud('articles', 'ArticlesCrudController');
    Route::crud('users', 'UsersCrudController');
    Route::crud('categories', 'CategoriesCrudController');
    Route::post('categories/quick-add', 'CategoriesCrudController@quickAdd')->name('admin.categories.quick-add');
    Route::post('articles/quick-add', 'ArticlesCrudController@quickAdd')->name('admin.articles.quick-add');

    Route::post('upload-image', function (\Illuminate\Http\Request $request) {
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            return response()->json(['success' => true, 'path' => '/storage/' . $path]);
        }
        return response()->json(['success' => false, 'message' => 'Aucun fichier reçu.']);
    });    

}); // this should be the absolute last line of this file

/**
 * DO NOT ADD ANYTHING HERE.
 */
