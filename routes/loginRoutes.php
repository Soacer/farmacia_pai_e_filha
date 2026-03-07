<?php

use App\Http\Controllers\Auth\User\useCases\AuthenticateUser\AuthenticateUserController;
use App\Http\Controllers\Auth\User\Views\AuthenticateUser\AuthenticateUserViewController;
use Illuminate\Support\Facades\Route;

//GET
Route::get('/auth', [AuthenticateUserViewController::class, 'auth'])->name('login');
Route::get('/cadastro', [AuthenticateUserViewController::class, 'cadastro'])->name('login/cadastro');
Route::get('/dashboard', [AuthenticateUserViewController::class, 'dashboard'])->middleware('auth')->name('dashboard');

//POST 
Route::post('/auth', [AuthenticateUserController::class, 'authenticateUser'])->name('login/auth');