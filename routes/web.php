<?php

use Illuminate\Support\Facades\Route;
Route::group([], base_path('routes/userRoutes.php')); //Agrupa as rotas que estão em userRoutes.php
Route::group([], base_path('routes/loginRoutes.php')); //Agrupa as rotas que estão em loginRoutes.php

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/user')->group(base_path('routes/userRoutes.php')); //O prefixo /user será adicionado a todas as rotas definidas em userRoutes.php
Route::prefix('/login')->group(base_path('routes/loginRoutes.php')); //O prefixo /login será adicionado a todas as rotas definidas em loginRoutes.php
