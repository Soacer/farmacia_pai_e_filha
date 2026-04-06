<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\EmployeeController;

//GET
Route::get('/employees/create', [EmployeeController::class, 'showCreateForm'])->name('create_employee');
Route::get('/employees/list', [EmployeeController::class, 'showAllEmployees'])->name('all_employees');

//POST
Route::post('/employees/store', [EmployeeController::class, 'store'])->name('store_employee');
