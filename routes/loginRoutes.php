<?php

use App\Http\Controllers\Auth\loginController;
use Illuminate\Support\Facades\Route;

Route::get('/auth', [loginController::class, 'auth'])->name('login/auth');
Route::get('/cadastro', [loginController::class, 'cadastro'])->name('login/cadastro');