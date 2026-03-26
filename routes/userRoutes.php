<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;

Route::middleware('web')->group(function () {
    //GET
    Route::get('/cadastro', [UserController::class, 'showRegistrationForm'])->name('create_customer');

    //POST
    Route::post('/create-customer', [UserController::class, 'createUser'])->name('store_customer');
});