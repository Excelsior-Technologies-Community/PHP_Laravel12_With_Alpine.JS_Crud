<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// Posts CRUD routes

// Display all posts
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

// Show create form
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');

// Store new post
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

// Show single post
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');

// Show edit form
Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');

// Update post
Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');

// Delete post
Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

Route::get('/', function () {
    return view('welcome');
});