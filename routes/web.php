<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Redirect root to tasks list
Route::get('/', fn() => redirect()->route('tasks.index'));

// Resource routes (index, create, store, edit, update, destroy)
Route::resource('tasks', TaskController::class)->except(['show']);

// Bonus: mark as done with one click
Route::patch('tasks/{task}/done', [TaskController::class, 'markDone'])->name('tasks.done');
