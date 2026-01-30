<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\User\useCases\CreateUser\CreateUserController;
use App\Http\Controllers\Auth\User\useCases\RetrieveUser\RetrieveUserController;
use App\Http\Controllers\Auth\User\useCases\UpdateUser\UpdateUserController;

Route::post('/create-user', [createUserController::class, 'createUser']);
Route::put('/update-user/{$id}', [updateUserController::class, 'updateUser']);
Route::get('/retrieve-user', [retrieveUserController::class, 'retrieveUser']);
