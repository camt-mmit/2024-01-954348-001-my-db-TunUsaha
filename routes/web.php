<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(ProductController::class)
    ->prefix('products')
    ->name('products.')
    ->group(function () {
        Route::get('', 'list')->name('list');
        Route::get('/create', 'showCreateForm')->name('create-form');
        Route::post('/create', 'create')->name('create');
        Route::get('/{product}', 'show')->name('view');
        Route::get('/{product}/edit', 'showEditForm')->name('edit-form');
        Route::put('/{product}', 'update')->name('update');
        Route::delete('/{product}', 'delete')->name('delete');
    });

    Route::controller(ShopController::class)
    ->prefix('shops')
    ->name('shops.')
    ->group(static function () {
        Route::get('', 'index')->name('list');
        Route::get('/create', 'showCreateForm')->name('create-form');
        Route::post('/create', 'create')->name('create');
        Route::get('{shop}', 'show')->name('view');
        Route::get('{shop}/edit', 'showEditForm')->name('edit-form');
        Route::put('{shop}', 'update')->name('update');
        Route::delete('{shop}', 'delete')->name('delete');
    });


