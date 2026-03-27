<?php

use App\Http\Controllers\Product\ProductController;
use Illuminate\Support\Facades\Route;

// GET
Route::get('/product-form', [ProductController::class, 'showCreateProductForm'])->name('create_product');
Route::get('/all-products', [ProductController::class, 'showAllProducts'])->name('select_all_products');

// POST
Route::post('/create-product', [ProductController::class, 'createProduct'])->name('store_product');
