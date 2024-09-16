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
    ->group(static function () {
        Route::get('', 'list')->name('list');
        Route::get('/create', 'showCreateForm')->name('create-form');
        Route::post('/create', 'create')->name('create');
        Route::get('/{product}', 'show')->name('view');
        Route::get('/{product}/edit', 'showEditForm')->name('edit-form');
        Route::put('/{product}', 'update')->name('update');
        Route::delete('/{product}', 'delete')->name('delete');
        Route::prefix('/{product}/shops')->group(static function () {
            Route::get('', 'showShops')->name('view-shops');
            Route::get('/add', 'showAddShopsForm')->name('add-shops-form');
            Route::post('/add', 'addShop')->name('add-shop');
            Route::get('/{shop}/remove', 'removeShop')
                ->name('remove-shop');
        });
    });


Route::controller(ShopController::class)
    ->prefix('shops')
    ->name('shops.')
    ->group(static function () {
        Route::get('', 'index')->name('list');
        Route::get('/create', 'showCreateForm')->name('create-form');
        Route::post('/create', 'create')->name('create');
        Route::get('/{shop}', 'show')->name('view');
        Route::get('/{shop}/edit', 'showEditForm')->name('edit-form');
        Route::put('/{shop}', 'update')->name('update');
        Route::delete('/{shop}', 'delete')->name('delete');
        Route::prefix('/{shop}/products')->group(static function () {
            Route::get('', 'showProducts')->name('view-products');
            Route::get('/add', 'showAddProductsForm')->name('add-products-form');
            Route::post('/add', 'addProduct')->name('add-product');
            Route::get('/{product}/remove', 'removeProduct')
                ->name('remove-product');
        });
    });

Route::controller(CategoriesController::class)
    ->prefix('categories')
    ->name('categories.')
    ->group(static function () {
        Route::get('', 'index')->name('list');
        Route::get('/create', 'showCreateForm')->name('create-form');
        Route::post('/create', 'create')->name('create');

        Route::get('/{category}', 'show')->name('view');
        Route::get('/{category}/edit', 'showEditForm')->name('edit-form');
        Route::put('/{category}', 'update')->name('update');
        Route::delete('/{category}', 'delete')->name('delete');
        Route::prefix('/{category}/products')->group(static function () {
            Route::get('', 'showProducts')->name('view-products');
            Route::get('/add', 'showAddProductsForm')->name('add-products-form');
            Route::post('/add', 'addProduct')->name('add-product');
            Route::get('/{product}/remove', 'removeProduct')
                ->name('remove-product');
        });
    });
