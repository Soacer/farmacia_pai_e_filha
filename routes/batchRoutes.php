<?php

use App\Http\Controllers\Product\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Batch\BatchController;

// PATCH
Route::patch('/product/{id}/deactivate-batches', [BatchController::class, 'deactivateProductBatches'])->name('deactivate_batches');

Route::middleware(['auth'])->prefix('batches')->group(function () {
    // GET
    Route::get('/list', [BatchController::class, 'showAllBatches'])->name('batches.list');

    // PUT
    Route::put('/update/{id}', [BatchController::class, 'update'])->name('batches.update');
    
    // PATCH
    Route::patch('/toggle/{id}', [BatchController::class, 'toggleStatus'])->name('batches.toggle');
});