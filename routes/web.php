<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'home'])->name('home');
Route::get('/categories', [\App\Http\Controllers\HomeController::class, 'categories'])->name('categories');

