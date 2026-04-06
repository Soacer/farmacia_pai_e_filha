<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Supplier\SupplierController;

//GET
Route::get('/supplier-form', [SupplierController::class, 'showCreateSupplierForm'])->name('create_supplier');
Route::get('/list-suppliers', [SupplierController::class, 'showAllSuppliers'])->name('list_suppliers');

//POST
Route::post('/store-supplier', [SupplierController::class, 'createSupplier'])->name('store_supplier');

//PUT
Route::put('/supplier/update/{id}', [SupplierController::class, 'updateSupplier'])->name('update_supplier');

//PATCH
Route::patch('/supplier/deactivate/{id}', [SupplierController::class, 'deactivateSupplier'])->name('deactivate_supplier');