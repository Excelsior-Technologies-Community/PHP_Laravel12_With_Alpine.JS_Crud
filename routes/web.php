<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// ✅ EXTRA ROUTES FIRST (VERY IMPORTANT)
Route::get('/posts/trash', [PostController::class, 'trash'])->name('posts.trash');
Route::get('/posts/restore/{id}', [PostController::class, 'restore'])->name('posts.restore');
Route::get('/posts/toggle/{id}', [PostController::class, 'toggleStatus'])->name('posts.toggle');
// Inline edit route
Route::patch('/posts/{post}/inline-update', [App\Http\Controllers\PostController::class, 'inlineUpdate'])->name('posts.inline-update');

// Resource route LAST
Route::resource('posts', PostController::class);

// Home route
Route::get('/', function () {
    return view('welcome');
});