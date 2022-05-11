<?php

use Illuminate\Support\Facades\Route;

Route::get('/categories/all', [\App\Http\Controllers\Api\CategoryController::class, 'all'])->name('categories.all');
Route::apiResource('/categories', \App\Http\Controllers\Api\CategoryController::class)->only(['index', 'show', 'store', 'destroy']);
