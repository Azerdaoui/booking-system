<?php

use App\Http\Controllers\EmployeeServiceIndexController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/employees/{employee}', EmployeeServiceIndexController::class)->name('employee');
