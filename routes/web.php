<?php

use Illuminate\Support\Facades\Route;
Route::group([], base_path('routes/userRoutes.php')); //Agrupa as rotas que estão em userRoutes.php

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/user')->group(base_path('routes/userRoutes.php')); //O prefixo /user será adicionado a todas as rotas definidas em userRoutes.php
