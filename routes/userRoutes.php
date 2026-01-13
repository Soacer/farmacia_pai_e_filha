<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\createUserController;
use App\Http\Controllers\updateUserController;
use App\Http\Controllers\retrieveUserController;

Route::post('/create-user', [createUserController::class, 'createUser']);
Route::put('/update-user/{$id}', [updateUserController::class, 'updateUser']);
Route::get('/retrieve-user', [retrieveUserController::class, 'retrieveUser']);
