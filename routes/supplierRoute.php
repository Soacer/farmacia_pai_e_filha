<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Supplier\SupplierController;

// Não precisa do middleware('web') aqui se ele já estiver sendo chamado no web.php
Route::get('/supplier-form', [SupplierController::class, 'showCreateSupplierForm'])->name('create_supplier');
Route::post('/store-supplier', [SupplierController::class, 'createSupplier'])->name('store_supplier');