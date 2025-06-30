<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticlesController;

Route::get('/', [ArticlesController::class, 'index'])->name('articles.index');
Route::get('/categorie/{id}', [ArticlesController::class, 'index'])->name('categorie.filter');

