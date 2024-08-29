<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CategoriesController;
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
        Route::get('/{product}/shops', 'showShops')->name('view-shops');
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
        Route::get('/{shop}/products', 'showProducts')->name('view-products');
    });

    Route::controller(CategoriesController::class)
    ->prefix('categories')
    ->name('categories.')
    ->group(static function () {
        Route::get('', 'index')->name('list');
        Route::get('/create', 'showCreateForm')->name('create-form');
        Route::post('/create', 'create')->name('create');
        Route::get('{category}', 'show')->name('view');
        Route::get('{category}/edit', 'showEditForm')->name('edit-form');
        Route::put('{category}', 'update')->name('update');
        Route::delete('{category}', 'delete')->name('delete');
        Route::get('/{category}/products', 'showProducts')->name('view-products');
    });
