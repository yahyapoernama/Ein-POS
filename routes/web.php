<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::prefix('products')->name('products.')->group(function () {
        Route::resource('/', ProductController::class)->parameters(['' => 'id']);
        Route::prefix('utils')->name('utils.')->group(function () {
            Route::get('/get-data', [ProductController::class, 'getData'])->name('getData');
        });
    });

    Route::prefix('categories')->name('categories.')->group(function () {
        Route::resource('/', CategoryController::class)->parameters(['' => 'id']);
        Route::prefix('utils')->name('utils.')->group(function () {
            Route::get('/get-data', [CategoryController::class, 'getData'])->name('getData');
            Route::get('/select2', [CategoryController::class, 'select2'])->name('select2');
        });
    });
});
