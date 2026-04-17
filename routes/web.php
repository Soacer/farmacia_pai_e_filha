<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;

Route::get('/', [WelcomeController::class, 'index'])->name('home');

Route::prefix('/user')->group(base_path('routes/userRoutes.php'));
Route::prefix('/login')->group(base_path('routes/loginRoutes.php'));
Route::middleware('web')->group(function () {
    Route::prefix('/product')->group(base_path('routes/productRoutes.php'));
    Route::prefix('/supplier')->group(base_path('routes/supplierRoute.php'));
    Route::prefix('/employee')->group(base_path('routes/employeeRoutes.php'));
});
