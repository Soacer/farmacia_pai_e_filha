<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/user')->group(base_path('routes/userRoutes.php'));
Route::prefix('/login')->group(base_path('routes/loginRoutes.php'));
Route::prefix('product')->group(base_path('routes/productRoutes.php'));