<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// GET
Route::get('/auth', [LoginController::class, 'showLoginForm'])->name('login');

// POST
Route::post('/auth', [LoginController::class, 'authenticate'])->name('login/auth');

// ROTAS DE AUTENTICAÇÃO PROTEGIDAS POR MIDDLEWARE
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [LoginController::class, 'showDashboard'])->middleware('auth')->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
