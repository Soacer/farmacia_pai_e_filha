<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Product\ProductController;

Route::middleware('web')->group(function(){
    //GET
    Route::get('/product-form', [ProductController::class, 'showCreateProductForm'])->name('create_product');

    //POST
    Route::post('/create-product', [ProductController::class, 'createProduct'])->name('store_product');
});