<?php

use App\Http\Controllers\CategoriesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {
    Route::prefix('categories')->group(function () {
        Route::get('', [CategoriesController::class, 'list']);

        Route::post('/add/', [CategoriesController::class, 'add']);
        Route::post('/edit/', [CategoriesController::class, 'edit']);

        Route::delete('/remove/{id}/', [CategoriesController::class, 'remove']);
    });

    Route::prefix('posts')->group(function () {
        Route::get('', [CategoriesController::class, 'list']);

        Route::post('/add/', [CategoriesController::class, 'add']);
        Route::post('/edit/', [CategoriesController::class, 'edit']);

        Route::delete('/remove/{id}/', [CategoriesController::class, 'remove']);
    });
});
