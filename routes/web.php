<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/user')->group(base_path('routes/userRoutes.php'));
Route::prefix('/login')->group(base_path('routes/loginRoutes.php'));
Route::middleware('web')->group(function () {
    Route::prefix('/product')->group(base_path('routes/productRoutes.php'));
    Route::prefix('/supplier')->group(base_path('routes/supplierRoute.php'));
    Route::prefix('/employee')->group(base_path('routes/employeeRoutes.php'));
});
