<?php

use App\Http\Controllers\Product\ProductController;
use Illuminate\Support\Facades\Route;

// GET
Route::get('/product-form', [ProductController::class, 'showCreateProductForm'])->name('create_product');
Route::get('/all-products', [ProductController::class, 'showAllProducts'])->name('select_all_products');
Route::get('/{id}', [ProductController::class, 'showProductById'])->name('select_product_by_id');

// POST
Route::post('/create-product', [ProductController::class, 'createProduct'])->name('store_product');

//PUT
Route::put('/product/update/{id}', [ProductController::class, 'updateProduct'])->name('update_product');

//PATCH
Route::patch('/product/deactivate/{id}', [ProductController::class, 'deactivateProduct'])->name('deactivate_product');