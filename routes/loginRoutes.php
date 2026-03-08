<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    // GET
    Route::get('/auth', [LoginController::class, 'showLoginForm'])->name('login');
    Route::get('/cadastro', [LoginController::class, 'showRegistrationForm'])->name('login/cadastro');

    // POST
    Route::post('/auth', [LoginController::class, 'authenticate'])->name('login/auth');

    // GET AUTH
    Route::get('/dashboard', [LoginController::class, 'showDashboard'])->middleware('auth')->name('dashboard');
});
